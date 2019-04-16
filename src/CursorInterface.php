<?php
/**
 * Plasma Core component
 * Copyright 2018-2019 PlasmaPHP, All Rights Reserved
 *
 * Website: https://github.com/PlasmaPHP
 * License: https://github.com/PlasmaPHP/core/blob/master/LICENSE
 */

namespace Plasma;

/**
 * The cursor interface describes how a cursor can be accessed to fetch rows
 * from the server interactively.
 */
interface CursorInterface {
    /**
     * Whether the cursor has been closed.
     * @return bool
     */
    function isClosed(): bool;
    
    /**
     * Closes the cursor and frees the associated resources on the server.
     * Closing a cursor more than once has no effect.
     * @return \React\Promise\PromiseInterface
     */
    function close(): \React\Promise\PromiseInterface;
    
    /**
     * Fetches the given amount of rows using the cursor. Resolves with the row, an array of rows (if amount > 1), or false if no more results exist.
     * @param int  $amount
     * @return \React\Promise\PromiseInterface
     * @throws \Plasma\Exception  Thrown if the underlying statement has been closed.
     */
    function fetch(int $amount = 1): \React\Promise\PromiseInterface;
}
