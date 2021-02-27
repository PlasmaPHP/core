<?php
/**
 * Plasma Core component
 * Copyright 2018-2019 PlasmaPHP, All Rights Reserved
 *
 * Website: https://github.com/PlasmaPHP
 * License: https://github.com/PlasmaPHP/core/blob/master/LICENSE
*/

namespace Plasma;

use Evenement\EventEmitterTrait;
use Obsidian\Validation\Validator;
use React\Promise;
use React\Promise\Deferred;
use React\Promise\PromiseInterface;

/**
 * The plasma client, responsible for pooling and connections.
 */
class Client implements ClientInterface {
    use EventEmitterTrait;
    
    /**
     * @var DriverFactoryInterface
     */
    protected $factory;
    
    /**
     * @var string
     */
    protected $uri;
    
    /**
     * @var array
     */
    protected $options = array(
        'connections.max' => 5,
        'connections.lazy' => false
    );
    
    /**
     * @var PromiseInterface
     */
    protected $goingAway;
    
    /**
     * @var \SplObjectStorage
     */
    protected $connections;
    
    /**
     * @var \SplObjectStorage
     */
    protected $busyConnections;
    
    /**
     * Creates a client with the specified factory and options.
     *
     * Available options:
     * ```
     * array(
     *     'connections.max' => int, (the maximum amount of connections to open, defaults to 5)
     *     'connections.lazy' => bool, (whether the first connection should be established lazily (on first request), defaults to false)
     * )
     * ```
     *
     * @param DriverFactoryInterface  $factory
     * @param string                  $uri
     * @param array                   $options
     * @throws \InvalidArgumentException
     * @throws \InvalidArgumentException  The driver may throw this exception when invalid arguments (connect uri) were given, this may be thrown later when connecting lazy.
     */
    function __construct(DriverFactoryInterface $factory, string $uri, array $options = array()) {
        $this->validateOptions($options);
        
        $this->factory = $factory;
        $this->uri = $uri;
        $this->options = \array_merge($this->options, $options);
        
        $this->connections = new \SplObjectStorage();
        $this->busyConnections = new \SplObjectStorage();
        
        if(!$this->options['connections.lazy']) {
            $connection = $this->createNewConnection();
            if($connection->getConnectionState() !== DriverInterface::CONNECTION_OK) {
                $this->busyConnections->attach($connection);
            }
        }
    }
    
    /**
     * Creates a client with the specified factory and options.
     * @param DriverFactoryInterface  $factory
     * @param string                  $uri
     * @param array                   $options
     * @return ClientInterface
     * @throws \Throwable  The client implementation may throw any exception during this operation.
     * @see Client::__construct()
     */
    static function create(DriverFactoryInterface $factory, string $uri, array $options = array()): ClientInterface {
        return (new static($factory, $uri, $options));
    }
    
    /**
     * Get the amount of connections.
     * @return int
     */
    function getConnectionCount(): int {
        return ($this->connections->count() + $this->busyConnections->count());
    }
    
    /**
     * Checks a connection back in, if usable and not closing.
     * @param DriverInterface  $driver
     * @return void
     */
    function checkinConnection(DriverInterface $driver): void {
        if(!$this->goingAway && $driver->getConnectionState() !== DriverInterface::CONNECTION_UNUSABLE) {
            $this->connections->attach($driver);
            $this->busyConnections->detach($driver);
        }
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
     * @return PromiseInterface
     * @throws Exception
     * @see \Plasma\Transaction
     */
    function beginTransaction(int $isolation = TransactionInterface::ISOLATION_COMMITTED): PromiseInterface {
        if($this->goingAway) {
            return Promise\reject((new Exception('Client is closing all connections')));
        }
        
        $connection = $this->getOptimalConnection();
        
        return $connection->beginTransaction($this, $isolation)->then(null, function (\Throwable $error) use (&$connection) {
            $this->checkinConnection($connection);
            throw $error;
        });
    }
    
    /**
     * Executes a plain query. Resolves with a `QueryResult` instance.
     * @param string  $query
     * @return PromiseInterface
     * @throws Exception
     * @see \Plasma\QueryResultInterface
     */
    function query(string $query): PromiseInterface {
        if($this->goingAway) {
            return Promise\reject((new Exception('Client is closing all connections')));
        }
        
        $connection = $this->getOptimalConnection();
        
        return $connection->query($this, $query)->then(null, function (\Throwable $error) use (&$connection) {
            $this->checkinConnection($connection);
            throw $error;
        });
    }
    
    /**
     * Prepares a query. Resolves with a `StatementInterface` instance.
     * @param string  $query
     * @return PromiseInterface
     * @throws Exception
     * @see \Plasma\StatementInterface
     */
    function prepare(string $query): PromiseInterface {
        if($this->goingAway) {
            return Promise\reject((new Exception('Client is closing all connections')));
        }
        
        $connection = $this->getOptimalConnection();
        
        return $connection->prepare($this, $query)->then(null, function (\Throwable $error) use (&$connection) {
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
     * @return PromiseInterface
     * @throws Exception
     * @see \Plasma\StatementInterface
     */
    function execute(string $query, array $params = array()): PromiseInterface {
        if($this->goingAway) {
            return Promise\reject((new Exception('Client is closing all connections')));
        }
        
        $connection = $this->getOptimalConnection();
        
        return $connection->execute($this, $query, $params)->then(function ($value) use (&$connection) {
            $this->checkinConnection($connection);
            return $value;
        }, function (\Throwable $error) use (&$connection) {
            $this->checkinConnection($connection);
            throw $error;
        });
    }
    
    /**
     * Quotes the string for use in the query.
     * @param string  $str
     * @param int     $type  For types, see the driver interface constants.
     * @return string
     * @throws \LogicException  Thrown if the driver does not support quoting.
     * @throws Exception        Thrown if the client is closing all connections.
     * @throws \Throwable
     */
    function quote(string $str, int $type = DriverInterface::QUOTE_TYPE_VALUE): string {
        if($this->goingAway) {
            throw new Exception('Client is closing all connections');
        }
        
        $connection = $this->getOptimalConnection();
        
        try {
            $quoted = $connection->quote($str, $type);
        } catch (\Throwable $e) {
            $this->checkinConnection($connection);
            throw $e;
        }
        
        return $quoted;
    }
    
    /**
     * Closes all connections gracefully after processing all outstanding requests.
     * @return PromiseInterface
     */
    function close(): PromiseInterface {
        if($this->goingAway) {
            return $this->goingAway;
        }
        
        $deferred = new Deferred();
        $this->goingAway = $deferred->promise();
        
        $closes = array();
        
        /** @var DriverInterface $conn */
        foreach($this->connections as $conn) {
            $closes[] = $conn->close();
            $this->connections->detach($conn);
        }
        
        /** @var DriverInterface $conn */
        foreach($this->busyConnections as $conn) {
            $closes[] = $conn->close();
            $this->busyConnections->detach($conn);
        }
    
        Promise\all($closes)->then(array($deferred, 'resolve'), array($deferred, 'reject'));
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
        
        $this->goingAway = Promise\resolve();
        
        /** @var DriverInterface $conn */
        foreach($this->connections as $conn) {
            $conn->quit();
            $this->connections->detach($conn);
        }
        
        /** @var DriverInterface $conn */
        foreach($this->busyConnections as $conn) {
            $conn->quit();
            $this->busyConnections->detach($conn);
        }
    }
    
    /**
     * Runs the given command.
     * @param CommandInterface  $command
     * @return mixed  Return depends on command and driver.
     * @throws Exception  Thrown if the client is closing all connections.
     * @throws \Throwable
     */
    function runCommand(CommandInterface $command) {
        if($this->goingAway) {
            throw new Exception('Client is closing all connections');
        }
        
        $connection = $this->getOptimalConnection();
        
        try {
            return $connection->runCommand($this, $command);
        } catch (\Throwable $e) {
            $this->checkinConnection($connection);
            throw $e;
        }
    }
    
    /**
     * Runs the given querybuilder on an underlying driver instance.
     * The driver CAN throw an exception if the given querybuilder is not supported.
     * An example would be a SQL querybuilder and a Cassandra driver.
     * @param QueryBuilderInterface  $query
     * @return PromiseInterface
     * @throws Exception
     * @throws \Throwable
     */
    function runQuery(QueryBuilderInterface $query): PromiseInterface {
        if($this->goingAway) {
            return Promise\reject((new Exception('Client is closing all connections')));
        }
        
        $connection = $this->getOptimalConnection();
        
        try {
            return $connection->runQuery($this, $query);
        } catch (\Throwable $e) {
            $this->checkinConnection($connection);
            throw $e;
        }
    }
    
    /**
     * Creates a new cursor to seek through SELECT query results.
     * @param string  $query
     * @param array   $params
     * @return PromiseInterface
     * @throws Exception
     * @throws \Throwable
     */
    function createReadCursor(string $query, array $params = array()): PromiseInterface {
        if($this->goingAway) {
            return Promise\reject((new Exception('Client is closing all connections')));
        }
        
        $connection = $this->getOptimalConnection();
        
        try {
            return $connection->createReadCursor($this, $query, $params);
        } catch (\Throwable $e) {
            $this->checkinConnection($connection);
            throw $e;
        }
    }
    
    /**
     * Get the optimal connection.
     * @return DriverInterface
     */
    protected function getOptimalConnection(): DriverInterface {
        if(\count($this->connections) === 0 && \count($this->busyConnections) < $this->options['connections.max']) {
            $connection = $this->createNewConnection();
            $this->busyConnections->attach($connection);
            
            return $connection;
        }
        
        /** @var DriverInterface $connection */
        $this->connections->rewind();
        $connection = $this->connections->current();
        
        $backlog = $connection->getBacklogLength();
        $state = $connection->getBusyState();
        
        /** @var DriverInterface $conn */
        foreach($this->connections as $conn) {
            $cbacklog = $conn->getBacklogLength();
            $cstate = $conn->getBusyState();
            
            if($cbacklog === 0 && $cstate === DriverInterface::STATE_IDLE && $conn->getConnectionState() === DriverInterface::CONNECTION_OK) {
                $this->connections->detach($conn);
                $this->busyConnections->attach($conn);
                
                return $conn;
            }
            
            if($backlog > $cbacklog || $state > $cstate) {
                $connection = $conn;
                $backlog = $cbacklog;
                $state = $cstate;
            }
        }
        
        if($this->getConnectionCount() < $this->options['connections.max']) {
            $connection = $this->createNewConnection();
        }
        
        $this->connections->detach($connection);
        $this->busyConnections->attach($connection);
        
        return $connection;
    }
    
    /**
     * Create a new connection.
     * @return DriverInterface
     */
    protected function createNewConnection(): DriverInterface {
        $connection = $this->factory->createDriver();
        
        // We relay a driver's specific events forward, e.g. PostgreSQL notifications
        $connection->on('eventRelay', function (string $eventName, ...$args) use (&$connection) {
            $args[] = $connection;
            $this->emit($eventName, $args);
        });
        
        $connection->on('close', function () use (&$connection) {
            $this->connections->detach($connection);
            $this->busyConnections->detach($connection);
            
            $this->emit('close', array($connection));
        });
        
        $connection->on('error', function (\Throwable $error) use (&$connection) {
            $this->emit('error', array($error, $connection));
        });
        
        $connection->connect($this->uri)->then(function () use (&$connection) {
            $this->connections->attach($connection);
            $this->busyConnections->detach($connection);
            
            $this->emit('newConnection', array($connection));
        }, function (\Throwable $error) use (&$connection) {
            $this->connections->detach($connection);
            $this->busyConnections->detach($connection);
            
            $this->emit('error', array($error, $connection));
        });
        
        return $connection;
    }
    
    /**
     * Validates the given options.
     * @param array  $options
     * @return void
     * @throws \InvalidArgumentException
     */
    protected function validateOptions(array $options): void {
        Validator::make(array(
            'connections.max' => 'integer|min:1',
            'connections.lazy' => 'boolean'
        ))->validate($options, \InvalidArgumentException::class);
    }
}
