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

use Plasma\Exception;
use Plasma\Utility;

class UtilityTest extends TestCase {
    function testParseParameters() {
        [ 'query' => $query, 'parameters' => $params ] = Utility::parseParameters(
            'SELECT `a` FROM `HERE_WE_GO` WHERE a < ? AND b = :named OR  c = $1',
            null
        );
        
        self::assertSame('SELECT `a` FROM `HERE_WE_GO` WHERE a < ? AND b = :named OR  c = $1', $query);
        self::assertSame(array(
            1 => '?',
            2 => ':named',
            3 => '$1'
        ), $params);
    }
    
    function testParseParametersReplace() {
        [ 'query' => $query, 'parameters' => $params ] = Utility::parseParameters(
            'SELECT `a` FROM `HERE_WE_GO` WHERE a < ? AND b = :named OR  c = $1',
            '?'
        );
        
        self::assertSame('SELECT `a` FROM `HERE_WE_GO` WHERE a < ? AND b = ? OR  c = ?', $query);
        self::assertSame(array(
            1 => '?',
            2 => ':named',
            3 => '$1'
        ), $params);
    }
    
    function testParseParametersCallback() {
        [ 'query' => $query, 'parameters' => $params ] = Utility::parseParameters(
            'SELECT `a` FROM `HERE_WE_GO` WHERE a < :na AND b = $5 OR  c = ?',
            function () {
                static $i;
                
                if(!$i) {
                    $i = 0;
                }
                
                return '$'.(++$i);
            }
        );
        
        self::assertSame('SELECT `a` FROM `HERE_WE_GO` WHERE a < $1 AND b = $2 OR  c = $3', $query);
        self::assertSame(array(
            1 => ':na',
            2 => '$5',
            3 => '?'
        ), $params);
    }
    
    function testReplaceParameters() {
        [ 'parameters' => $params ] = Utility::parseParameters('SELECT `a` FROM `HERE_WE_GO` WHERE a < :na AND b = $5 OR  c = ?', '?');
        
        $myParams = array(
            ':na' => 5,
            1 => true,
            2 => 'hello'
        );
        
        self::assertSame(array(
            0 => 5,
            1 => true,
            2 => 'hello'
        ), Utility::replaceParameters($params, $myParams));
    }
    
    function testReplaceParametersInsufficientParams() {
        [ 'parameters' => $params ] = Utility::parseParameters('SELECT `a` FROM `HERE_WE_GO` WHERE a < :na AND b = $5 OR  c = ?', '?');
        
        $myParams = array();
        
        $this->expectException(Exception::class);
        Utility::replaceParameters($params, $myParams);
    }
    
    function testReplaceParametersInsufficientParams2() {
        [ 'parameters' => $params ] = Utility::parseParameters('SELECT `a` FROM `HERE_WE_GO` WHERE a < :na AND b = $5 OR  c = ?', '?');
        
        $myParams = array(
            true,
            true,
            true,
            true,
            true,
            true
        );
        
        $this->expectException(Exception::class);
        Utility::replaceParameters($params, $myParams);
    }
}
