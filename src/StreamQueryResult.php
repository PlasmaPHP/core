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
 * A query result stream. Used to get rows row by row, as sent by the DBMS.
 * To adhere to the `react/stream` standard,a `close` event
 * will be emitted after the `end` or `error` event.
 */
class StreamQueryResult implements StreamQueryResultInterface {
    use \Evenement\EventEmitterTrait;
    
    /**
     * @var \Plasma\CommandInterface
     */
    protected $command;
    
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
     * @var \Plasma\ColumnDefinitionInterface[]|null
     */
    protected $columns;
    
    /**
     * @var array|null
     */
    protected $rows;
    
    /**
     * Constructor.
     * @param \Plasma\CommandInterface                  $command
     * @param int                                       $affectedRows
     * @param int                                       $warningsCount
     * @param int|null                                  $insertID
     * @param \Plasma\ColumnDefinitionInterface[]|null  $columns
     */
    function __construct(\Plasma\CommandInterface $command, int $affectedRows = 0, int $warningsCount = 0, ?int $insertID = null, ?array $columns = null) {
        $this->command = $command;
        
        $this->affectedRows = $affectedRows;
        $this->warningsCount = $warningsCount;
        
        $this->insertID = $insertID;
        $this->columns = $columns;
        
        $buffer = function ($row) {
            $this->emit('data', array($row));
        };
        
        $command->on('data', $buffer);
        
        $command->once('end', function () use ($buffer) {
            $this->removeListener('data', $buffer);
            
            $this->emit('end');
            $this->emit('close');
        });
        
        $command->once('error', function (\Throwable $error) use ($buffer) {
            $this->removeListener('data', $buffer);
            
            $this->emit('error', array($error));
            $this->emit('close');
        });
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
     * Get the used insert ID for the row, if any. `INSERT` statements only.
     * @return int|null
     */
    function getInsertID(): ?int {
        return $this->insertID;
    }
    
    /**
     * Get the field definitions, if any. `SELECT` statements only.
     * @return \Plasma\ColumnDefinitionInterface[]|null
     */
    function getFieldDefinitions(): ?array {
        return $this->columns;
    }
    
    /**
     * Get the rows, if any. Returns always `null`.
     * @return array|null
     */
    function getRows(): ?array {
        return null;
    }
    
    /**
     * Buffers all rows and returns a promise which resolves with an instance of `QueryResultInterface`.
     * This method does not guarantee that all rows get returned, as the buffering depends on when this
     * method gets invoked. There's no automatic buffering, as such rows may be missing if invoked too late.
     * @return \React\Promise\PromiseInterface
     */
    function all(): \React\Promise\PromiseInterface {
        return \React\Promise\Stream\all($this)->then(function (array $rows) {
            return (new \Plasma\QueryResult($this->affectedRows, $this->warningsCount, $this->insertID, $this->columns, $rows));
        });
    }
}
