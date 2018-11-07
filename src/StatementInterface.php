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
 * Represents any prepared statement.
 */
interface StatementInterface {
    /**
     * Get the driver-dependent ID of this statement.
     * The return type can be of ANY type, as the ID depends on the driver and DBMS.
     * @return mixed
     */
    function getID();
    
    /**
     * Closes the prepared statement and frees the associated resources on the server.
     * @return \React\Promise\PromiseInterface
     */
    function close(): \React\Promise\PromiseInterface;
    
    /**
     * Executes the prepared statement. Resolves with a `QueryResult` instance.
     * @param array  $params
     * @return \React\Promise\PromiseInterface
     * @see \Plasma\QueryResultInterface
     */
    function execute(array $params): \React\Promise\PromiseInterface;
}
