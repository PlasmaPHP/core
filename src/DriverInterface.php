<?php
/**
 * Plasma Core component
 * Copyright 2018-2019 PlasmaPHP, All Rights Reserved
 *
 * Website: https://github.com/PlasmaPHP
 * License: https://github.com/PlasmaPHP/core/blob/master/LICENSE
*/

namespace Plasma;

use Evenement\EventEmitterInterface;
use React\Promise\PromiseInterface;

/**
 * The minimum public API a driver has to maintain. The driver MUST emit a `close` event when it gets disconnected from the server.
 */
interface DriverInterface extends EventEmitterInterface {
    /**
     * Driver is idling and ready for requests.
     * @var int
     * @source
     */
    const STATE_IDLE = 0;
    
    /**
     * Driver is busy.
     * @var int
     * @source
     */
    const STATE_BUSY = 1;
    
    /**
     * The connection is closed and can not be reused.
     * @var int
     * @source
     */
    const CONNECTION_UNUSABLE = 0;
    
    /**
     * Connection closed.
     * @var int
     * @source
     */
    const CONNECTION_CLOSED = 1;
    
    /**
     * Waiting for connection to be made.
     * @var int
     * @source
     */
    const CONNECTION_STARTED = 2;
    
    /**
     * Connection OK; waiting to send.
     * @var int
     * @source
     */
    const CONNECTION_MADE = 3;
    
    /**
     * Waiting for a response from the server.
     * @var int
     * @source
     */
    const CONNECTION_AWAITING_RESPONSE = 4;
    
    /**
     * Received authentication; waiting for backend startup.
     * @var int
     * @source
     */
    const CONNECTION_AUTH_OK = 5;
    
    /**
     * Negotiating environment.
     * @var int
     * @source
     */
    const CONNECTION_SETENV = 6;
    
    /**
     * Negotiating SSL.
     * @var int
     * @source
     */
    const CONNECTION_SSL_STARTUP = 7;
    
    /**
     * Connection is made and ready for use.
     * @var int
     * @source
     */
    const CONNECTION_OK = 8;
    
    /**
     * Quoting should be applied on an identifier (such as table name, column name, etc.)
     * @var int
     * @source
     */
    const QUOTE_TYPE_IDENTIFIER = 0;
    
    /**
     * Quoting should be applied on a value.
     * @var int
     * @source
     */
    const QUOTE_TYPE_VALUE = 1;
    
    /**
     * Retrieves the current connection state.
     * @return int
     */
    function getConnectionState(): int;
    
    /**
     * Retrieves the current busy state.
     * @return int
     */
    function getBusyState(): int;
    
    /**
     * Get the length of the driver backlog queue.
     * @return int
     */
    function getBacklogLength(): int;
    
    /**
     * Connects to the given URI.
     * @param string  $uri
     * @return PromiseInterface
     * @throws \InvalidArgumentException
     */
    function connect(string $uri): PromiseInterface;
    
    /**
     * Closes all connections gracefully after processing all outstanding requests.
     * @return PromiseInterface
     */
    function close(): PromiseInterface;
    
    /**
     * Forcefully closes the connection, without waiting for any outstanding requests. This will reject all outstanding requests.
     * @return void
     */
    function quit(): void;
    
    /**
     * Whether this driver is currently in a transaction.
     * @return bool
     */
    function isInTransaction(): bool;
    
    /**
     * Executes a plain query. Resolves with a `QueryResultInterface` instance.
     * When the command is done, the driver must check itself back into the client.
     * @param ClientInterface  $client
     * @param string           $query
     * @return PromiseInterface
     * @throws Exception
     * @see \Plasma\QueryResultInterface
     */
    function query(ClientInterface $client, string $query): PromiseInterface;
    
    /**
     * Prepares a query. Resolves with a `StatementInterface` instance.
     * When the command is done, the driver must check itself back into the client.
     * @param ClientInterface  $client
     * @param string           $query
     * @return PromiseInterface
     * @throws Exception
     * @see \Plasma\StatementInterface
     */
    function prepare(ClientInterface $client, string $query): PromiseInterface;
    
    /**
     * Prepares and executes a query. Resolves with a `QueryResultInterface` instance.
     * This is equivalent to prepare -> execute -> close.
     * If you need to execute a query multiple times, prepare the query manually for performance reasons.
     * @param ClientInterface  $client
     * @param string           $query
     * @param array            $params
     * @return PromiseInterface
     * @throws Exception
     * @see \Plasma\StatementInterface
     */
    function execute(ClientInterface $client, string $query, array $params = array()): PromiseInterface;
    
    /**
     * Quotes the string for use in the query.
     * @param string  $str
     * @param int     $type  For types, see the constants.
     * @return string
     * @throws \LogicException  Thrown if the driver does not support quoting.
     * @throws Exception
     */
    function quote(string $str, int $type = DriverInterface::QUOTE_TYPE_VALUE): string;
    
    /**
     * Begins a transaction. Resolves with a `TransactionInterface` instance.
     *
     * Checks out a connection until the transaction gets committed or rolled back.
     * It must be noted that the user is responsible for finishing the transaction. The client WILL NOT automatically
     * check the connection back into the pool, as long as the transaction is not finished.
     *
     * Some databases, including MySQL, automatically issue an implicit COMMIT when a database definition language (DDL)
     * statement such as DROP TABLE or CREATE TABLE is issued within a transaction.
     * The implicit COMMIT will prevent you from rolling back any other changes within the transaction boundary.
     * @param ClientInterface  $client
     * @param int              $isolation  See the `TransactionInterface` constants.
     * @return PromiseInterface
     * @throws Exception
     * @see \Plasma\TransactionInterface
     */
    function beginTransaction(ClientInterface $client, int $isolation = TransactionInterface::ISOLATION_COMMITTED): PromiseInterface;
    
    /**
     * Informationally closes a transaction. This method is used by `Transaction` to inform the driver of the end of the transaction.
     * @return void
     */
    function endTransaction(): void;
    
    /**
     * Runs the given command.
     * When the command is done, the driver must check itself back into the client.
     * @param ClientInterface   $client
     * @param CommandInterface  $command
     * @return mixed  Return depends on command and driver.
     */
    function runCommand(ClientInterface $client, CommandInterface $command);
    
    /**
     * Runs the given querybuilder.
     * The driver CAN throw an exception if the given querybuilder is not supported.
     * An example would be a SQL querybuilder and a Cassandra driver.
     * @param ClientInterface        $client
     * @param QueryBuilderInterface  $query
     * @return PromiseInterface
     * @throws Exception
     */
    function runQuery(ClientInterface $client, QueryBuilderInterface $query): PromiseInterface;
    
    /**
     * Creates a new cursor to seek through SELECT query results. Resolves with a `CursorInterface` instance.
     * @param ClientInterface  $client
     * @param string           $query
     * @param array            $params
     * @return PromiseInterface
     * @throws \LogicException  Thrown if the driver or DBMS does not support cursors.
     * @throws Exception
     */
    function createReadCursor(ClientInterface $client, string $query, array $params = array()): PromiseInterface;
}
