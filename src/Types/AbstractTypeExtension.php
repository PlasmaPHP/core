<?php
/**
 * Plasma Core component
 * Copyright 2018-2019 PlasmaPHP, All Rights Reserved
 *
 * Website: https://github.com/PlasmaPHP
 * License: https://github.com/PlasmaPHP/core/blob/master/LICENSE
*/

namespace Plasma\Types;

use Plasma\ColumnDefinitionInterface;

/**
 * An abstract type extension.
 */
abstract class AbstractTypeExtension implements TypeExtensionInterface {
    /**
     * @var string
     */
    protected $type;
    
    /**
     * @var mixed
     */
    protected $dbType;
    
    /**
     * @var callable
     */
    protected $filter;
    
    /**
     * Constructor.
     * @param string    $type
     * @param mixed     $dbType
     * @param callable  $filter
     */
    function __construct(string $type, $dbType, callable $filter) {
        $this->type = $type;
        $this->dbType = $dbType;
        $this->filter = $filter;
    }
    
    /**
     * Whether the type extension can handle the conversion of the passed value.
     * Before this method is used, the common types are checked first.
     * `class` -> `interface` -> `type` -> this.
     * @param mixed                           $value
     * @param ColumnDefinitionInterface|null  $column
     * @return bool
     */
    function canHandleType($value, ?ColumnDefinitionInterface $column): bool {
        $cb = $this->filter;
        return $cb($value, $column);
    }
    
    /**
     * Get the human-readable type this Type Extension is for.
     * @return string  E.g. `BIGINT`, `VARCHAR`, etc.
     */
    function getHumanType(): string {
        return $this->type;
    }
    
    /**
     * Get the database type this Type Extension is for.
     * @return mixed
     */
    function getDatabaseType() {
        return $this->dbType;
    }
    
    /**
     * Encodes a PHP value into a binary database value.
     * @param mixed                      $value   The value to encode.
     * @param ColumnDefinitionInterface  $column
     * @return TypeExtensionResultInterface
     */
    abstract function encode($value, ColumnDefinitionInterface $column): TypeExtensionResultInterface;
    
    /**
     * Decodes a binary database value into a PHP value.
     * @param mixed  $value  The encoded binary. Actual type depends on the driver.
     * @return TypeExtensionResultInterface
     */
    abstract function decode($value): TypeExtensionResultInterface;
}
