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
 * Any queryable class (can execute queries) implements this indirectly or directly.
 */
interface QueryableInterface {
    /**
     * Executes a plain query. Resolves with a `QueryResult` instance.
     * @param string  $query
     * @return \React\Promise\PromiseInterface
     * @throws \Plasma\Exception
     * @see \Plasma\QueryResultInterface
     */
    function query(string $query): \React\Promise\PromiseInterface;
    
    /**
     * Prepares a query. Resolves with a `StatementInterface` instance.
     * @param string  $query
     * @return \React\Promise\PromiseInterface
     * @throws \Plasma\Exception
     * @see \Plasma\StatementInterface
     */
    function prepare(string $query): \React\Promise\PromiseInterface;
    
    /**
     * Quotes the string for use in the query.
     * @param string  $str
     * @return string
     * @throws \LogicException  Thrown if the driver does not support quoting.
     */
    function quote(string $str): string;
}
