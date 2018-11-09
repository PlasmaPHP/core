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
 * Column Definitions define columns (who would've thought of that?). Such as their name, type, length, etc.
 */
class ColumnDefinition {
    /**
     * @var string
     */
    protected $database;
    
    /**
     * @var string
     */
    protected $table;
    
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var string
     */
    protected $type;
    
    /**
     * @var string
     */
    protected $charset;
    
    /**
     * @var int|null
     */
    protected $length;
    
    /**
     * @var bool
     */
    protected $nullable;
    
    /**
     * @var int
     */
    protected $flags;
    
    /**
     * Constructor.
     * @param string    $database
     * @param string    $table
     * @param string    $name
     * @param string    $type
     * @param string    $charset
     * @param int|null  $length
     * @param bool      $nullable
     * @param int       $flags
     */
    function __construct(string $database, string $table, string $name, string $type, string $charset, ?int $length, bool $nullable, int $flags) {
        $this->database = $database;
        $this->table = $table;
        $this->name = $name;
        $this->type = $type;
        $this->charset = $charset;
        $this->length = $length;
        $this->nullable = $nullable;
        $this->flags = $flags;
    }
    
    /**
     * Get the database name this column is in.
     * @return string
     */
    function getDatabaseName(): string {
        return $this->database;
    }
    
    /**
     * Get the table name this column is in.
     * @return string
     */
    function getTableName(): string {
        return $this->table;
    }
    
    /**
     * Get the column name.
     * @return string
     */
    function getName(): string {
        return $this->name;
    }
    
    /**
     * Get the type name, such as `BIGINT`, `VARCHAR`, etc.
     * @return string
     */
    function getType(): string {
        return $this->type;
    }
    
    /**
     * Get the charset, such as `utf8mb4`.
     * @return string
     */
    function getCharset(): string {
        return $this->charset;
    }
    
    /**
     * Get the maximum field length, if any.
     * @return int|null
     */
    function getLength(): ?int {
        return $this->length;
    }
    
    /**
     * Whether the column is nullable (not `NOT NULL`).
     * @return bool
     */
    function isNullable(): bool {
        return $this->nullable;
    }
    
    /**
     * Get the column flags.
     * @return int
     */
    function getFlags(): int {
        return $this->flags;
    }
    
    /**
     * Parses the row value into the field type.
     * @return mixed
     */
    function parseValue($value) { // TODO
        return $value;
    }
}
