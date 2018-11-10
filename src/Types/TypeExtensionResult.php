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
 * Represents a successful encoding conversion.
 */
class TypeExtensionResult {
    /**
     * @var mixed
     */
    protected $type;
    
    /**
     * @var mixed
     */
    protected $value;
    
    /**
     * Constructor.
     * @param mixed  $type
     * @param mixed  $value
     */
    function __construct($type, $value) {
        $this->type = $type;
        $this->value = $value;
    }
    
    /**
     * Get the SQL type.
     * @return mixed  Driver-dependent.
     */
    function getSQLType() {
        return $this->type;
    }
    
    /**
     * Get the encoded value.
     * @return mixed
     */
    function getValue() {
        return $this->value;
    }
}
