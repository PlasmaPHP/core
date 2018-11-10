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
 * The Type Extension Manager manages type extensions globally.
 * A case, where two different drivers are used in the same application,
 * is very rare. As such the normal use case is accessing statically.
 *
 * Types should be automatically registered by the driver factory,
 * UNLESS the user opts-out of this behaviour.
 *
 * For standard PHP types (such as `string`, `float`, etc.),
 * the type identifier is the type name (`float is used instead of `double`).
 * For classes you can also use an interface name (e.g. `JsonSerializable`).
 */
class TypeExtensionsManager {
    /**
     * List of PHP types.
     * @var string[]
     * @source
     */
    const PHP_TYPES = array('string', 'boolean', 'float', 'integer', 'object', 'array', 'resource', 'resource (closed)', 'NULL');
    
    /**
     * @var \Plasma\Types\TypeExtensionInterface[]
     */
    protected $regularTypes = array();
    
    /**
     * @var \Plasma\Types\TypeExtensionInterface[]
     */
    protected $classTypes = array();
    
    /**
     * @var \Plasma\Types\TypeExtensionInterface[]
     */
    protected $sqlTypes = array();
    
    /**
     * @var bool
     */
    protected $enableFuzzySearch = true;
    
    /**
     * @var self
     */
    protected $instance;
    
    /**
     * Handles calling the methods statically.
     * @param string  $name
     * @param array   $args
     */
    function __callStatic(string $name, array $args) {
        if(!static::$instance) {
            static::$instance = new static();
        }
        
        return static::$instance->$name(...$args);
    }
    
    /**
     * Registers a type.
     * @param mixed                                 $typeIdentifier
     * @param \Plasma\Types\TypeExtensionInterface  $type
     * @return void
     * @throws \Plasma\Exception  Thrown if the type identifier is already in use.
     */
    function registerType($typeIdentifier, \Plasma\Types\TypeExtensionInterface $type): void {
        if(isset($this->regularTypes[$typeIdentifier]) || isset($this->classTypes[$typeIdentifier])) {
            throw new \Plasma\Exception('Type identifier is already in use');
        }
        
        if(\in_array($typeIdentifier, static::PHP_TYPES, true)) {
            $this->regularTypes[$typeIdentifier] = $type;
        } else {
            $this->classTypes[$typeIdentifier] = $type;
        }
    }
    
    /**
     * Unregisters a type. A non-existent type identifier does nothing.
     * @param mixed  $typeIdentifier
     * @return void
     */
    function unregisterType($typeIdentifier): void {
        unset($this->regularTypes[$typeIdentifier], $this->classTypes[$typeIdentifier]);
    }
    
    /**
     * Registers a type.
     * @param mixed                                 $typeIdentifier  Depends on the driver.
     * @param \Plasma\Types\TypeExtensionInterface  $type
     * @return void
     * @throws \Plasma\Exception  Thrown if the type identifier is already in use.
     */
    function registerSQLType($typeIdentifier, \Plasma\Types\TypeExtensionInterface $type): void {
        if(isset($this->sqlTypes[$typeIdentifier])) {
            throw new \Plasma\Exception('SQL Type identifier is already in use');
        }
        
        $this->sqlTypes[$typeIdentifier] = $type;
    }
    
    /**
     * Unregisters a SQL type. A non-existent type identifier does nothing.
     * @param mixed  $typeIdentifier  The used type identifier. Depends on the driver.
     * @return void
     */
    function unregisterSQLType($typeIdentifier): void {
        unset($this->sqlTypes[$typeIdentifier]);
    }
    
    /**
     * Enables iterating over all types and invoking `canHandleType`, if quick type check is failing.
     * @return void
     */
    function enableFuzzySearch(): void {
        $this->enableFuzzySearch = true;
    }
    
    /**
     * Disables iterating over all types and invoking `canHandleType`, if quick type check is failing.
     * @return void
     */
    function disableFuzzySearch(): void {
        $this->enableFuzzySearch = false;
    }
    
    /**
     * Tries to encode a value.
     * @param mixed  $value
     * @return \Plasma\Types\TypeExtensionResultInterface
     * @throws \Plasma\Exception  Thrown if unable to encode the value.
     */
    function encodeType($value): \Plasma\Types\TypeExtensionResultInterface {
        $type = \gettype($value);
        if($type === 'double') {
            $type = 'float';
        }
        
        $classes = ($type === 'object' ? \array_merge(array(\get_class($value)), \class_parents($value), \class_implements($value)) : array());
        
        /** @var \Plasma\Types\TypeExtensionInterface  $encoder */
        foreach($this->classTypes as $key => $encoder) {
            if(\in_array($key, $classes, true)) {
                return $encoder->encode($value);
            }
        }
        
        /** @var \Plasma\Types\TypeExtensionInterface  $encoder */
        foreach($this->regularTypes as $key => $encoder) {
            if($type === $key) {
                return $encoder->encode($value);
            }
        }
        
        if($this->enableFuzzySearch) {
            /** @var \Plasma\Types\TypeExtensionInterface  $encoder */
            foreach($this->classTypes as $key => $encoder) {
                if($encoder->canHandleType($value)) {
                    return $encoder->encode($value);
                }
            }
            
            /** @var \Plasma\Types\TypeExtensionInterface  $encoder */
            foreach($this->regularTypes as $key => $encoder) {
                if($encoder->canHandleType($value)) {
                    return $encoder->encode($value);
                }
            }
        }
        
        throw new \Plasma\Exception('Unable to encode given value');
    }
    
    /**
     * Tries to decode a value.
     * @param mixed|null  $type  The driver-dependent SQL type identifier. Can be `null` to not use the fast-path.
     * @param mixed       $value
     * @return mixed
     * @throws \Plasma\Exception  Thrown if unable to decode the value.
     */
    function decodeType($type, $value) {
        if($type === null) {
            /** @var \Plasma\Types\TypeExtensionInterface  $decoder */
            foreach($this->sqlTypes as $sqlType => $decoder) {
                if($decoder->canHandleType($value)) {
                    return $decoder->decode($value);
                }
            }
        } elseif(isset($this->sqlTypes[$type])) {
            return $this->sqlTypes[$type]->decode($value);
        }
        
        throw new \Plasma\Exception('Unable to decode given value');
    }
}
