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
 * The minimum public API a driver has to maintain. The driver MUST emit a `close` event when it gets disconnected from the server.
 */
interface DriverInterface extends \Evenement\EventEmitterInterface, QueryableInterface {
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
     * Retrieves the current connection state.
     * @return int
     */
    function getConnectionState(): int;
    
    /**
     * Get the length of the driver backlog queue.
     * @return int
     */
    function getBacklogLength(): int;
    
    /**
     * Connects to the given URI.
     * @return \React\Promise\PromiseInterface
     */
    function connect(string $uri): \React\Promise\PromiseInterface;
    
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
    
    /**
     * Whether this driver is currently in a transaction.
     * @return bool
     */
    function isInTransaction(): bool;
}
