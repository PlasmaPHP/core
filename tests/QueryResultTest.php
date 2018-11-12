<?php
/**
 * Plasma Core component
 * Copyright 2018 PlasmaPHP, All Rights Reserved
 *
 * Website: https://github.com/PlasmaPHP
 * License: https://github.com/PlasmaPHP/core/blob/master/LICENSE
*/

namespace Plasma\Tests;

class QueryResultTest extends TestCase {
    function testGetAffectedRows() {
        $result = new \Plasma\QueryResult(0, 1, null);
        $this->assertSame(0, $result->getAffectedRows());
    }
    
    function testGetWarningsCount() {
        $result = new \Plasma\QueryResult(0, 1, null);
        $this->assertSame(1, $result->getWarningsCount());
    }
    
    function testGetFieldDefinitions() {
        $result = new \Plasma\QueryResult(0, 1, null);
        $this->assertNull($result->getFieldDefinitions());
    }
    
    function testGetInsertID() {
        $result = new \Plasma\QueryResult(0, 1, null);
        $this->assertNull($result->getInsertID());
        
        $result2 = new \Plasma\QueryResult(0, 1, 52);
        $this->assertSame(52, $result2->getInsertID());
    }
}