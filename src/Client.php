<?php
/**
 * Plasma Core component
 * Copyright 2018 PlasmaPHP, All Rights Reserved
 *
 * Website: https://github.com/PlasmaPHP
 * License: https://github.com/PlasmaPHP/core/blob/master/LICENSE
*/

namespace Plasma;

/**
 * The plasma client, responsible for pooling and connections.
 */
class Client implements ClientInterface {
    use \Evenement\EventEmitterTrait;
    
    /**
     * @var \Plasma\DriverFactoryInterface
     */
    protected $factory;
    
    /**
     * @var array
     */
    protected $options = array(
        'maxConnections' => 5
    );
    
    /**
     * @var \React\Promise\PromiseInterface
     */
    protected $goingAway;
    
    /**
     * @var \SplObjectStorage
     */
    protected $connections;
    
    /**
     * @var \SplObjectStorage
     */
    protected $transactionConnections;
    
    /**
     * Creates a client with the specified factory and options.
     *
     * Available options:
     * ```
     * array(
     *     'maxConnections' => int, (the maximum amount of connections to open, defaults to 5)
     * )
     * ```
     *
     * @param \Plasma\DriverFactoryInterface  $factory
     * @param array                           $options
     * @throws \InvalidArgumentException
     */
    function __construct(\Plasma\DriverFactoryInterface $factory, array $options = array()) {
        $this->validateOptions($options);
        
        $this->factory = $factory;
        $this->options = \array_merge($this->options, $options);
        
        $this->connections = new \SplObjectStorage();
        $this->transactionConnections = new \SplObjectStorage();
        
        $this->createNewConnection();
    }
    
    /**
     * Creates a client with the specified factory and options.
     * @param \Plasma\DriverFactoryInterface  $factory
     * @param array                           $options
     * @throws \Throwable  The client implementation may throw any exception during this operation.
     * @see Client::__construct()
     */
    static function create(\Plasma\DriverFactoryInterface $factory, array $options = array()) {
        return (new static($factory, $options));
    }
    
    /**
     * Get the amount of connections.
     * @return int
     */
    function getConnectionCount(): int {
        return ($this->connections->count() + $this->transactionConnections->count());
    }
    
    /**
     * Begins a transaction. Resolves with a `Transaction` instance.
     *
     * Checks out a connection until the transaction gets committed or rolled back. If the transaction goes out of scope
     * and thus deallocated, the `Transaction` must check the connection back into the client.
     *
     * Some databases, including MySQL, automatically issue an implicit COMMIT when a database definition language (DDL)
     * statement such as DROP TABLE or CREATE TABLE is issued within a transaction.
     * The implicit COMMIT will prevent you from rolling back any other changes within the transaction boundary.
     * @param int  $isolation  See the `TransactionInterface` constants.
     * @return \React\Promise\PromiseInterface
     * @throws \Plasma\Exception
     * @see \Plasma\Transaction
     */
    function beginTransaction(int $isolation = \Plasma\TransactionInterface::ISOLATION_COMMITTED): \React\Promise\PromiseInterface {
        if($this->goingAway) {
            return \React\Promise\reject((new \Plasma\Exception('Client is closing all connections')));
        }
        
        $connection = $this->getOptimalConnection();
        
        return $connection->beginTransaction($this, $isolation)->then(function (\Plasma\TransactionInterface $value) use (&$connection) {
            $this->transactionConnections->attach($connection);
            return $value;
        }, function (\Throwable $error) use (&$connection) {
            $this->checkinConnection($connection);
            throw $error;
        });
    }
    
    /**
     * Checks a connection back in. This method is used by `TransactionInterface` instances.
     * @param \Plasma\DriverInterface  $driver
     * @return void
     */
    function checkinConnection(\Plasma\DriverInterface $driver): void {
        if($driver->getConnectionState() === \Plasma\DriverInterface::CONNECTION_OK && !$this->goingAway) {
            $this->connections->attach($driver);
            $this->transactionConnections->detach($driver);
        }
    }
    
    /**
     * Executes a plain query. Resolves with a `QueryResult` instance.
     * @param string  $query
     * @return \React\Promise\PromiseInterface
     * @see \Plasma\QueryResultInterface
     */
    function query(string $query): \React\Promise\PromiseInterface {
        if($this->goingAway) {
            return \React\Promise\reject((new \Plasma\Exception('Client is closing all connections')));
        }
        
        $connection = $this->getOptimalConnection();
        
        return $connection->query($this, $query)->otherwise(function (\Throwable $error) use (&$connection) {
            $this->checkinConnection($connection);
            throw $error;
        });
    }
    
    /**
     * Prepares a query. Resolves with a `StatementInterface` instance.
     * @param string  $query
     * @return \React\Promise\PromiseInterface
     * @see \Plasma\StatementInterface
     */
    function prepare(string $query): \React\Promise\PromiseInterface {
        if($this->goingAway) {
            return \React\Promise\reject((new \Plasma\Exception('Client is closing all connections')));
        }
        
        $connection = $this->getOptimalConnection();
        
        return $connection->prepare($this, $query)->otherwise(function (\Throwable $error) use (&$connection) {
            $this->checkinConnection($connection);
            throw $error;
        });
    }
    
    /**
     * Prepares and executes a query. Resolves with a `QueryResultInterface` instance.
     * This is equivalent to prepare -> execute -> close.
     * If you need to execute a query multiple times, prepare the query manually for performance reasons.
     * @param string  $query
     * @param array   $params
     * @return \React\Promise\PromiseInterface
     * @throws \Plasma\Exception
     * @see \Plasma\StatementInterface
     */
    function execute(string $query, array $params = array()): \React\Promise\PromiseInterface {
        if($this->goingAway) {
            return \React\Promise\reject((new \Plasma\Exception('Client is closing all connections')));
        }
        
        $connection = $this->getOptimalConnection();
        
        return $connection->execute($this, $query, $params)->always(function () use (&$connection) {
            $this->checkinConnection($connection);
        });
    }
    
    /**
     * Quotes the string for use in the query.
     * @param string  $str
     * @return string
     * @throws \LogicException    Thrown if the driver does not support quoting.
     * @throws \Plasma\Exception  Thrown if the client is closing all connections.
     */
    function quote(string $str): string {
        if($this->goingAway) {
            throw new \Plasma\Exception('Client is closing all connections');
        }
        
        $connection = $this->getOptimalConnection();
        $quoted = $connection->quote($query);
        
        $this->checkinConnection($connection);
        return $quoted;
    }
    
    /**
     * Closes all connections gracefully after processing all outstanding requests.
     * @return \React\Promise\PromiseInterface
     */
    function close(): \React\Promise\PromiseInterface {
        if($this->goingAway) {
            return $this->goingAway;
        }
        
        $deferred = new \React\Promise\Deferred();
        $this->goingAway = $deferred->promise();
        
        $closes = array();
        
        /** @var \Plasma\DriverInterface  $conn */
        foreach($this->connections as $conn) {
            $closes[] = $conn->close();
            $this->connections->detach($conn);
        }
        
        /** @var \Plasma\DriverInterface  $conn */
        foreach($this->transactionConnections as $conn) {
            $closes[] = $conn->close();
            $this->transactionConnections->detach($conn);
        }
        
        \React\Promise\all($closes)->then(array($deferred, 'resolve'), array($deferred, 'reject'));
        return $this->goingAway;
    }
    
    /**
     * Forcefully closes the connection, without waiting for any outstanding requests. This will reject all oustanding requests.
     * @return void
     */
    function quit(): void {
        if($this->goingAway) {
            return;
        }
        
        $this->goingAway = \React\Promise\resolve();
        
        /** @var \Plasma\DriverInterface  $conn */
        foreach($this->connections as $conn) {
            $conn->quit();
            $this->connections->detach($conn);
        }
        
        /** @var \Plasma\DriverInterface  $conn */
        foreach($this->transactionConnections as $conn) {
            $conn->quit();
            $this->transactionConnections->detach($conn);
        }
    }
    
    /**
     * Runs the given command.
     * @param \Plasma\CommandInterface  $command
     * @return mixed  Return depends on command and driver.
     * @throws \Plasma\Exception  Thrown if the client is closing all connections.
     */
    function runCommand(\Plasma\CommandInterface $command) {
        if($this->goingAway) {
            throw new \Plasma\Exception('Client is closing all connections');
        }
        
        $connection = $this->getOptimalConnection();
        return $connection->runCommand($this, $comamnd);
    }
    
    /**
     * Get the optimal connection.
     * @return \Plasma\DriverInterface
     */
    protected function getOptimalConnection() {
        if(\count($this->connections) === 0) {
            return $this->createNewConnection();
        }
        
        /** @var \Plasma\DriverInterface  $connection */
        $connection = $this->connections[0];
        $backlog = $connection->getBacklogLength();
        $state = $connection->getBusyState();
        $position = 0;
        
        /** @var \Plasma\DriverInterface  $conn */
        foreach($this->connections as $conn) {
            $cbacklog = $conn->getBacklogLength();
            $cstate = $conn->getBusyState();
            
            if($cbacklog === 0 && $conn->getConnectionState() === \Plasma\DriverInterface::CONNECTION_OK && $cstate == \Plasma\DriverInterface::STATE_IDLE) {
                $this->connections->detach($pos);
                return $conn;
            }
            
            if($backlog > $cbacklog || $state > $cstate) {
                $connection = $conn;
                $backlog = $cbacklog;
                $state = $cstate;
                $position = $pos;
            }
        }
        
        if($this->getConnectionCount() < $this->options['maxConnections']) {
            return $this->createNewConnection();
        }
        
        $this->connections->detach($connection);
        return $connection;
    }
    
    /**
     * Create a new connection.
     * @return \Plasma\DriverInterface
     */
    protected function createNewConnection() {
        /** @var \Plasma\DriverInterface  $connection */
        $connection = $this->factory->createDriver();
        
        // We relay a driver's specific events forward, e.g. PostgreSQL notifications
        $connection->on('eventRelay', function (string $eventName, array $args) use (&$connection) {
            $args[] = $connection;
            $this->emit($eventName, ...$args);
        });
        
        $connection->on('close', function () use (&$connection) {
            $this->connections->detach($connection);
            $this->transactionConnections->detach($connection);
            
            $this->emit('close', array($connection));
        });
        
        $connection->on('error', function (\Throwable $error) use (&$connection) {
            $this->emit('error', array($error, $connection));
        });
        
        $this->connections->attach($connection);
        return $connection;
    }
    
    /**
     * Validates the given options.
     * @param array  $options
     * @return void
     * @throws \InvalidArgumentException
     */
    protected function validateOptions(array $options) {
        $validator = \CharlotteDunois\Validation\Validator::make($options, array(
            'maxConnections' => 'int|min:1'
        ));
        
        $validator->throw(\InvalidArgumentException::class);
    }
}
