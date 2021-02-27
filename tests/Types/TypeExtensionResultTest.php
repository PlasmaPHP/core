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

use Plasma\Tests\TestCase;
use Plasma\Types\TypeExtensionResult;

class TypeExtensionResultTest extends TestCase {
    function testGetDatabaseType() {
        $result = new TypeExtensionResult('VARCHAR', false, 'hello mine turtle');
        self::assertSame('VARCHAR', $result->getDatabaseType());
    }
    
    function testIsUnsigned() {
        $result = new TypeExtensionResult('VARCHAR', false, 'hello mine turtle');
        self::assertFalse($result->isUnsigned());
    }
    
    function testGetValue() {
        $result = new TypeExtensionResult('VARCHAR', false, 'hello mine turtle');
        self::assertSame('hello mine turtle', $result->getValue());
    }
}
