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
 * A class representing a regular query result (no SELECT), with no event emitter.
 */
class QueryResult implements QueryResultInterface {
    /**
     * @var int
     */
    protected $affectedRows;
    
    /**
     * @var int
     */
    protected $warningsCount;
    
    /**
     * @var int|null
     */
    protected $insertID;
    
    /**
     * Constructor.
     * @param int       $affectedRows
     * @param int       $warningsCount
     * @param int|null  $insertID
     */
    function __construct(int $affectedRows, int $warningsCount, ?int $insertID) {
        $this->affectedRows = $affectedRows;
        $this->warningsCount = $warningsCount;
        $this->insertID = $insertID;
    }
    
    /**
     * Get the number of affected rows (for UPDATE, DELETE, etc.).
     * @return int
     */
    function getAffectedRows(): int {
        return $this->affectedRows;
    }
    
    /**
     * Get the number of warnings sent by the server.
     * @return int
     */
    function getWarningsCount(): int {
        return $this->warningsCount;
    }
    
    /**
     * Get the field definitions, if any. `SELECT` statements only.
     * @return array|null
     */
    function getFieldDefinitions(): ?array {
        return null;
    }
    
    /**
     * Get the used insert ID for the row, if any. `INSERT` statements only.
     * @return int|null
     */
    function getInsertID(): ?int {
        return $this->insertID;
    }
}
