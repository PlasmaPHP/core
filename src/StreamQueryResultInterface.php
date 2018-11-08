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
 * This is the more advanced query result interface, which is a readable stream.
 * That means, for `SELECT` statements a `data` event will be emitted for each row.
 * At the end of a query, a `end` event will be emitted to notify of the completion.
 */
interface StreamQueryResultInterface extends \React\Stream\ReadableStreamInterface, QueryResultInterface {
    
}