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

use Plasma\QueryResult;

class QueryResultTest extends TestCase {
    function testGetAffectedRows() {
        $result = new QueryResult(0, 1, 1, null, null);
        self::assertSame(0, $result->getAffectedRows());
    }
    
    function testGetWarningsCount() {
        $result = new QueryResult(0, 1, 1, null, null);
        self::assertSame(1, $result->getWarningsCount());
    }
    
    function testGetInsertID() {
        $result = new QueryResult(0, 1, null, null, null);
        self::assertNull($result->getInsertID());
        
        $result2 = new QueryResult(0, 1, 52, null, null);
        self::assertSame(52, $result2->getInsertID());
    }
    
    function testGetFieldDefinitions() {
        $result = new QueryResult(0, 1, 1, null, null);
        self::assertNull($result->getFieldDefinitions());
    }
    
    function testGetFieldDefinitionsNotNull() {
        /** @noinspection PhpParamsInspection */
        $result = new QueryResult(0, 1, 1, array(5), null);
        self::assertSame(array(5), $result->getFieldDefinitions());
    }
    
    function testGetRows() {
        $result = new QueryResult(0, 1, 1, null, array(1));
        self::assertSame(array(1), $result->getRows());
    }
}
