<?php
/**
 * Plasma Core component
 * Copyright 2018-2019 PlasmaPHP, All Rights Reserved
 *
 * Website: https://github.com/PlasmaPHP
 * License: https://github.com/PlasmaPHP/core/blob/master/LICENSE
 * @noinspection PhpUnhandledExceptionInspection
*/

namespace Plasma\Tests;

use Plasma\ColumnDefinitionInterface;
use Plasma\Types\AbstractTypeExtension;
use Plasma\Types\TypeExtensionResult;
use Plasma\Types\TypeExtensionResultInterface;
use Plasma\Types\TypeExtensionsManager;

class AbstractColumnDefinitionTest extends ClientTestHelpers {
    function testGetTableName() {
        $coldef = $this->getColDefMock('test2', 'coltest', 'BIGINT', 'utf8mb4', 20, 0, null);
        self::assertSame('test2', $coldef->getTableName());
    }
    
    function testGetName() {
        $coldef = $this->getColDefMock('test2', 'coltest', 'BIGINT', 'utf8mb4', 20, 0, null);
        self::assertSame('coltest', $coldef->getName());
    }
    
    function testGetType() {
        $coldef = $this->getColDefMock('test2', 'coltest', 'BIGINT', 'utf8mb4', 20, 0, null);
        self::assertSame('BIGINT', $coldef->getType());
    }
    
    function testGetCharset() {
        $coldef = $this->getColDefMock('test2', 'coltest', 'BIGINT', 'utf8mb4', 20, 0, null);
        self::assertSame('utf8mb4', $coldef->getCharset());
    }
   
    function testGetLength() {
        $coldef = $this->getColDefMock('test2', 'coltest', 'BIGINT', 'utf8mb4', 20, 0, null);
        self::assertSame(20, $coldef->getLength());
        
        $coldef2 = $this->getColDefMock('test2', 'coltest', 'BIGINT', 'utf8mb4', null, 0, null);
        self::assertNull($coldef2->getLength());
    }
    
    function testGetFlags() {
        $coldef = $this->getColDefMock('test2', 'coltest', 'BIGINT', 'utf8mb4', 20, 0, null);
        self::assertSame(0, $coldef->getFlags());
    }
    
    function testGetDecimals() {
        $coldef = $this->getColDefMock('test2', 'coltest', 'BIGINT', 'utf8mb4', 20, 0, null);
        self::assertNull($coldef->getDecimals());
        
        $coldef2 = $this->getColDefMock('test2', 'coltest', 'BIGINT', 'utf8mb4', 20, 0, 2);
        self::assertSame(2, $coldef2->getDecimals());
    }
    
    function testParseValueNoMatchingType() {
        // Make sure we don't have a database type decoder from testParseValue lying around
        TypeExtensionsManager::getManager()->unregisterDatabaseType('BIGINT');
        
        $coldef = $this->getColDefMock('test2', 'coltest', 'BIGINT', 'utf8mb4', 20, 0, null);
        self::assertSame('testValue', $coldef->parseValue('testValue'));
    }
    
    function testParseValue() {
        $type = (new class('int', 'BIGINT', 'is_numeric') extends AbstractTypeExtension {
            function encode($value, ColumnDefinitionInterface $a): TypeExtensionResultInterface {
                return (new TypeExtensionResult(0, false, $value));
            }
            
            function decode($value): TypeExtensionResultInterface {
                return (new TypeExtensionResult(0, false, ((int) $value)));
            }
        });
        
        TypeExtensionsManager::getManager()->registerDatabaseType('BIGINT', $type);
        
        $coldef = $this->getColDefMock('test2', 'coltest', 'BIGINT', 'utf8mb4', 20, 0, null);
        self::assertSame(500, $coldef->parseValue('500'));
    }
}
