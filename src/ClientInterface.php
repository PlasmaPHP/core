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
 * The client interface for plasma clients, responsible for creating drivers and pooling.
 * It also provides a minimal public API for checking out a connection, get work done and checking the connection back in.
 *
 * The client must support relaying forward events from the driver to the client. This is done with a driver event called `eventRelay`.
 * The listener callback for the driver is: `function (string $eventName, array $args)`.
 * The client must always append the driver the event occurred on at the end of the `$args`. And emit the event, called `$eventName`, on itself.
 */
interface ClientInterface extends \Evenement\EventEmitterInterface, QueryableInterface {
    /**
     * Creates a client with the specified factory and options.
     * @param \Plasma\DriverFactoryInterface  $factory
     * @param array                           $options  Any options for the client, see client implementation for details.
     * @throws \Throwable  The client implementation may throw any exception during this operation.
     */
    function __construct(\Plasma\DriverFactoryInterface $factory, array $options = array());
    
    /**
     * Get the amount of connections.
     * @return int
     */
    function getConnectionCount(): int;
    
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
     * @param int  $isolation  See the `TransactionInterface` constants.
     * @return \React\Promise\PromiseInterface
     * @throws \Plasma\Exception
     * @see \Plasma\TransactionInterface
     */
    function beginTransaction(int $isolation = \Plasma\TransactionInterface::ISOLATION_COMMITTED): \React\Promise\PromiseInterface;
    
    /**
     * Checks a connection back in. This method is used by `TransactionInterface` instances.
     * @param \Plasma\DriverInterface  $driver
     * @return void
     */
    function checkinConnection(\Plasma\DriverInterface $driver): void;
    
    /**
     * Closes all connections gracefully after processing all outstanding requests.
     * @return \React\Promise\PromiseInterface
     */
    function close(): \React\Promise\PromiseInterface;
    
    /**
     * Forcefully closes the connection, without waiting for any outstanding requests. This will reject all oustanding requests.
     * @return void
     */
    function quit(): void;
}
