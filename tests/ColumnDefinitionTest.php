<?php
/**
 * Plasma Core component
 * Copyright 2018 PlasmaPHP, All Rights Reserved
 *
 * Website: https://github.com/PlasmaPHP
 * License: https://github.com/PlasmaPHP/core/blob/master/LICENSE
*/

namespace Plasma\Tests;

class ColumnDefinitionTest extends ClientTestHelpers {
    /**
     * @var \Plasma\ColumnDefinitionInterface
     */
    protected $coldef;
    
    function setUp() {
        $this->coldef = new \Plasma\ColumnDefinition('test', 'test2', 'coltest', 'BIGINT', 'utf8mb4', 20, false, 0, null);
    }
    
     function testGetDatabaseName() {
        $this->assertSame('test', $this->coldef->getDatabaseName());
    }
    
    function testGetTableName() {
        $this->assertSame('test2', $this->coldef->getTableName());
    }
    
    function testGetName() {
        $this->assertSame('coltest', $this->coldef->getName());
    }
    
    function testGetType() {
        $this->assertSame('BIGINT', $this->coldef->getType());
    }
    
    function testGetCharset() {
        $this->assertSame('utf8mb4', $this->coldef->getCharset());
    }
   
    function testGetLength() {
        $this->assertSame(20, $this->coldef->getLength());
    }
    
    function testIsNullable() {
        $this->assertFalse($this->coldef->isNullable());
    }
    
    function testGetFlags() {
        $this->assertSame(0, $this->coldef->getFlags());
    }
    
    function testGetDecimals() {
        $this->assertNull($this->coldef->getDecimals());
    }
    
    function testParseValueNoMatchingType() {
        $this->assertSame('testValue', $this->coldef->parseValue('testValue'));
    }
    
    function testParseValue() {
        $type = (new class('int', 'BIGINT', 'is_numeric') extends \Plasma\Types\AbstractTypeExtension {
            function encode($value): \Plasma\Types\TypeExtensionResultInterface {
                return (new \Plasma\Types\TypeExtensionResult(0, false, $value));
            }
            
            function decode($value) {
                return ((int) $value);
            }
        });
        
        \Plasma\Types\TypeExtensionsManager::getManager()->registerType('BIGINT', $type);
        
        $this->assertSame('testValue', $this->coldef->parseValue('500'));
    }
}