<?php
/**
 * Plasma Core component
 * Copyright 2018-2019 PlasmaPHP, All Rights Reserved
 *
 * Website: https://github.com/PlasmaPHP
 * License: https://github.com/PlasmaPHP/core/blob/master/LICENSE
*/

namespace Plasma\Tests;

class ColumnDefinitionTest extends TestCase {
    function testGetDatabaseName() {
        $coldef = new \Plasma\ColumnDefinition('test', 'test2', 'coltest', 'BIGINT', 'utf8mb4', 20, false, 0, null);
        $this->assertSame('test', $coldef->getDatabaseName());
    }
    
    function testGetTableName() {
        $coldef = new \Plasma\ColumnDefinition('test', 'test2', 'coltest', 'BIGINT', 'utf8mb4', 20, false, 0, null);
        $this->assertSame('test2', $coldef->getTableName());
    }
    
    function testGetName() {
        $coldef = new \Plasma\ColumnDefinition('test', 'test2', 'coltest', 'BIGINT', 'utf8mb4', 20, false, 0, null);
        $this->assertSame('coltest', $coldef->getName());
    }
    
    function testGetType() {
        $coldef = new \Plasma\ColumnDefinition('test', 'test2', 'coltest', 'BIGINT', 'utf8mb4', 20, false, 0, null);
        $this->assertSame('BIGINT', $coldef->getType());
    }
    
    function testGetCharset() {
        $coldef = new \Plasma\ColumnDefinition('test', 'test2', 'coltest', 'BIGINT', 'utf8mb4', 20, false, 0, null);
        $this->assertSame('utf8mb4', $coldef->getCharset());
    }
   
    function testGetLength() {
        $coldef = new \Plasma\ColumnDefinition('test', 'test2', 'coltest', 'BIGINT', 'utf8mb4', 20, false, 0, null);
        $this->assertSame(20, $coldef->getLength());
        
        $coldef2 = new \Plasma\ColumnDefinition('test', 'test2', 'coltest', 'BIGINT', 'utf8mb4', null, false, 0, null);
        $this->assertNull($coldef2->getLength());
    }
    
    function testIsNullable() {
        $coldef = new \Plasma\ColumnDefinition('test', 'test2', 'coltest', 'BIGINT', 'utf8mb4', 20, false, 0, null);
        $this->assertFalse($coldef->isNullable());
    }
    
    function testGetFlags() {
        $coldef = new \Plasma\ColumnDefinition('test', 'test2', 'coltest', 'BIGINT', 'utf8mb4', 20, false, 0, null);
        $this->assertSame(0, $coldef->getFlags());
    }
    
    function testGetDecimals() {
        $coldef = new \Plasma\ColumnDefinition('test', 'test2', 'coltest', 'BIGINT', 'utf8mb4', 20, false, 0, null);
        $this->assertNull($coldef->getDecimals());
        
        $coldef2 = new \Plasma\ColumnDefinition('test', 'test2', 'coltest', 'BIGINT', 'utf8mb4', 20, false, 0, 2);
        $this->assertSame(2, $coldef2->getDecimals());
    }
    
    function testParseValueNoMatchingType() {
        $coldef = new \Plasma\ColumnDefinition('test', 'test2', 'coltest', 'BIGINT', 'utf8mb4', 20, false, 0, null);
        $this->assertSame('testValue', $coldef->parseValue('testValue'));
    }
    
    function testParseValue() {
        $type = (new class('int', 'BIGINT', 'is_numeric') extends \Plasma\Types\AbstractTypeExtension {
            function encode($value, \Plasma\ColumnDefinitionInterface $a): \Plasma\Types\TypeExtensionResultInterface {
                return (new \Plasma\Types\TypeExtensionResult(0, false, $value));
            }
            
            function decode($value): \Plasma\Types\TypeExtensionResultInterface {
                return (new \Plasma\Types\TypeExtensionResult(0, false, ((int) $value)));
            }
        });
        
        \Plasma\Types\TypeExtensionsManager::getManager()->registerSQLType('BIGINT', $type);
        
        $coldef = new \Plasma\ColumnDefinition('test', 'test2', 'coltest', 'BIGINT', 'utf8mb4', 20, false, 0, null);
        $this->assertSame(500, $coldef->parseValue('500'));
    }
}
