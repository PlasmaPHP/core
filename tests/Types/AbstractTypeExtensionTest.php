<?php
/**
 * Plasma Core component
 * Copyright 2018-2019 PlasmaPHP, All Rights Reserved
 *
 * Website: https://github.com/PlasmaPHP
 * License: https://github.com/PlasmaPHP/core/blob/master/LICENSE
 * @noinspection PhpUnhandledExceptionInspection
*/

namespace Plasma\Tests\Types;

use Plasma\ColumnDefinitionInterface;
use Plasma\Tests\TestCase;
use Plasma\Types\AbstractTypeExtension;
use Plasma\Types\TypeExtensionResultInterface;

class AbstractTypeExtensionTest extends TestCase {
    function testCanHandleType() {
        $type = (new class('VARCHAR', 0xFB, function ($a, $b) {
            return \is_string($a);
        }) extends AbstractTypeExtension {
            function encode($value, ColumnDefinitionInterface $a): TypeExtensionResultInterface {}
            function decode($value): TypeExtensionResultInterface {}
        });
        
        self::assertTrue($type->canHandleType('hello mineturtle', null));
        self::assertFalse($type->canHandleType(true, null));
    }
    
    function testGetHumanType() {
        $type = (new class('VARCHAR', 0xFB, function ($a, $b) {
            return \is_string($a);
        }) extends AbstractTypeExtension {
            function encode($value, ColumnDefinitionInterface $a): TypeExtensionResultInterface {}
            function decode($value): TypeExtensionResultInterface {}
        });
        
        self::assertSame('VARCHAR', $type->getHumanType());
    }
    
    function testGetDatabaseType() {
        $type = (new class('VARCHAR', 0xFB, 'is_string') extends AbstractTypeExtension {
            function encode($value, ColumnDefinitionInterface $a): TypeExtensionResultInterface {}
            function decode($value): TypeExtensionResultInterface {}
        });
        
        self::assertSame(0xFB, $type->getDatabaseType());
    }
}
