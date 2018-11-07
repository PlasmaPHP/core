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
 */
interface ClientInterface {
    /**
     * Creates a client for the specified driver and the driver construtor arguments.
     * @param string  $driver  A driver implementing `\Plasma\DriverInterface`.
     * @param array   $ctor    The constructor arguments for the driver.
     * @return self
     */
    static function create(string $driver, array $ctor): self;
    
    /**
     * Begins a transaction.
     *
     * Checks out a connection permanently until the transaction gets committed or rolled back.
     * It must be noted that the user is responsible for finishing the transaction. The client WILL NOT automatically
     * check the connection back into the pool, as long as the transaction is not finished.
     *
     * Some databases, including MySQL, automatically issue an implicit COMMIT when a database definition language (DDL)
     * statement such as DROP TABLE or CREATE TABLE is issued within a transaction.
     * The implicit COMMIT will prevent you from rolling back any other changes within the transaction boundary.
     * @return \Plasma\TransactionInterface
     */
    function beginTransaction(): \Plasma\TransactionInterface;
}
