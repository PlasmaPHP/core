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
    protected $options = array('maxConnections' => 5);
    
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
     * Closes all connections gracefully after processing all outstanding requests.
     * @return \React\Promise\PromiseInterface
     */
    function close(): \React\Promise\PromiseInterface {
        $closes = array();
        
        /** @var \Plasma\DriverInterface  $conn */
        foreach($this->connections as $conn) {
            $closes[] = $conn->close();
        }
        
        return \React\Promise\all($closes);
    }
    
    /**
     * Forcefully closes the connection, without waiting for any outstanding requests. This will reject all oustanding requests.
     * @return void
     */
    function quit(): void {
        /** @var \Plasma\DriverInterface  $conn */
        foreach($this->connections as $conn) {
            $conn->quit();
        }
    }
    
    /**
     * Get the amount of connections.
     * @return int
     */
    function getConnectionCount(): int {
        return ($this->connections->count() + $this->transactionConnections->count());
    }
    
    /**
     * Begins a transaction. Resolves with a `TransactionInterface` instance.
     *
     * Checks out a connection permanently until the transaction gets committed or rolled back. If the transaction goes out of scope
     * and thus deallocated, the `TransactionInterface` must check the connection back into the client.
     *
     * Some databases, including MySQL, automatically issue an implicit COMMIT when a database definition language (DDL)
     * statement such as DROP TABLE or CREATE TABLE is issued within a transaction.
     * The implicit COMMIT will prevent you from rolling back any other changes within the transaction boundary.
     * @return \React\Promise\PromiseInterface
     * @see \Plasma\TransactionInterface
     */
    function beginTransaction(int $isolation = \Plasma\TransactionInterface::ISOLATION_COMMITTED): \React\Promise\PromiseInterface {
        $connection = $this->getOptimalConnection();
        
        switch($isolation) {
            case \Plasma\TransactionInterface::ISOLATION_UNCOMMITTED:
                $query = 'BEGIN TRANSACTION ISOLATION LEVEL READ UNCOMMITTED';
            break;
            case \Plasma\TransactionInterface::ISOLATION_COMMITTED:
                $query = 'BEGIN TRANSACTION ISOLATION LEVEL READ COMMITTED';
            break;
            case \Plasma\TransactionInterface::ISOLATION_REPEATABLE:
                $query = 'BEGIN TRANSACTION ISOLATION LEVEL REPEATABLE READ';
            break;
            case \Plasma\TransactionInterface::ISOLATION_SERIALIZABLE:
                $query = 'BEGIN TRANSACTION ISOLATION LEVEL READ SERIALIZABLE';
            break;
        }
        
        return $connection->query($query)->then(function () use (&$connection, $isolation) {
            $this->transactionConnections->attach($connection);
            return (new \Plasma\Transaction($this, $connection, $isolation));
        }, function (\Throwable $error) use (&$connection) {
            $this->connections->attach($connection);
            throw $error;
        });
    }
    
    /**
     * Checks a connection back in. This method is used by `TransactionInterface` instances.
     * @param \Plasma\DriverInterface  $driver
     * @return void
     */
    function checkinConnection(\Plasma\DriverInterface $driver): void {
        if($driver->getConnectionState() === \Plasma\DriverInterface::CONNECTION_OK) {
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
        $connection = $this->getOptimalConnection();
        
        return $connection->query($query)->always(function () use (&$connection) {
            $this->connections->attach($connection);
        });
    }
    
    /**
     * Prepares a query. Resolves with a `StatementInterface` instance.
     * @param string  $query
     * @return \React\Promise\PromiseInterface
     * @see \Plasma\StatementInterface
     */
    function prepare(string $query): \React\Promise\PromiseInterface {
        $connection = $this->getOptimalConnection();
        
        return $connection->prepare($query)->always(function () use (&$connection) {
            $this->connections->attach($connection);
        });
    }
    
    /**
     * Quotes the string for use in the query.
     * @param string  $str
     * @return string
     * @throws \LogicException  Thrown if the driver does not support quoting.
     */
    function quote(string $str): string {
        $connection = $this->getOptimalConnection();
        $this->connections->attach($connection);
        
        return $connection->quote($query);
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
        $backlog = -1;
        $position = 0;
        
        /** @var \Plasma\DriverInterface  $conn */
        foreach($this->connections as $conn) {
            $cbacklog = $conn->getBacklogLength();
            
            if($cbacklog === 0 && $conn->getConnectionState() === \Plasma\DriverInterface::CONNECTION_OK) {
                $this->connections->detach($pos);
                return $conn;
            }
            
            if($backlog > $cbacklog) {
                $connection = $conn;
                $backlog = $cbacklog;
                $position = $pos;
            }
        }
        
        if($this->connections->count() < $this->options['maxConnections']) {
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
        
        $connection->on('close', function () use (&$connection) {
            $this->connections->detach($connection);
            $this->transactionConnections->detach($connection);
        });
        
        $this->connections->attach($connection);
        return $connection;
    }
    
    /**
     * Validates the given options.
     * @param array $options;
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
