<?php
/**
 * Plasma Core component
 * Copyright 2018 PlasmaPHP, All Rights Reserved
 *
 * Website: https://github.com/PlasmaPHP
 * License: https://github.com/PlasmaPHP/core/blob/master/LICENSE
*/

namespace Plasma\Types;

/**
 * An abstract type extension.
 */
abstract class AbstractTypeExtension implements TypeExtensionInterface {
    /**
     * @var string
     */
    protected $type;
    
    /**
     * @var callable
     */
    protected $filter;
    
    /**
     * Constructor.
     * @param string    $type
     * @param callable  $filter
     */
    function __construct(string $type, callable $filter) {
        $this->type = $type;
        $this->filter = $filter;
    }
    
    /**
     * Whether the type extension can handle the conversion of the passed value.
     * Before this method is used, the common types are checked first.
     * `class` -> `interface` -> `type` -> this.
     * @param mixed  $value
     * @return bool
     */
    function canHandleType($value): bool {
        $cb = $this->filter;
        return $cb($value);
    }
    
    /**
     * Get the human-readable type this Type Extension is for.
     * @return string  E.g. `BIGINT`, `VARCHAR`, etc.
     */
    function getHumanType(): string {
        return $this->type;
    }
    
    /**
     * Encodes a PHP value into a binary SQL value.
     * @param mixed   $value  The value to encode.
     * @return mixed  The encoded binary. Actual type depends on the driver.
     */
    abstract function encode($value): \Plasma\Types\TypeExtensionResultInterface;
    
    /**
     * Decodes a binary SQL value into a PHP value.
     * @param mixed  $value  The encoded binary. Actual type depends on the driver.
     * @return mixed  The decoded value.
     */
    abstract function encode($value): \Plasma\Types\TypeExtensionResultInterface;
}
