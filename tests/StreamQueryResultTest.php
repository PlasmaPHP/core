<?php
/**
 * Plasma Core component
 * Copyright 2018-2019 PlasmaPHP, All Rights Reserved
 *
 * Website: https://github.com/PlasmaPHP
 * License: https://github.com/PlasmaPHP/core/blob/master/LICENSE
*/

namespace Plasma\Tests;

class StreamQueryResultTest extends ClientTestHelpers {
    function testGetAffectedRows() {
        $command = $this->getCommandMock();
        
        $result = new \Plasma\StreamQueryResult($command, 0, 1, null, null);
        $this->assertSame(0, $result->getAffectedRows());
    }
    
    function testGetWarningsCount() {
        $command = $this->getCommandMock();
        
        $result = new \Plasma\StreamQueryResult($command, 0, 1, null, null);
        $this->assertSame(1, $result->getWarningsCount());
    }
    
    function testGetInsertID() {
        $command = $this->getCommandMock();
        
        $result = new \Plasma\StreamQueryResult($command, 0, 1, null, null);
        $this->assertNull($result->getInsertID());
        
        $result2 = new \Plasma\StreamQueryResult($command, 0, 1, 42, null);
        $this->assertSame(42, $result2->getInsertID());
    }
    
    function testGetFieldDefinitions() {
        $command = $this->getCommandMock();
        
        $result = new \Plasma\StreamQueryResult($command, 0, 1, null, null);
        $this->assertNull($result->getFieldDefinitions());
        
        $fields = array(
            $this->getColDefMock('test2', 'coltest', 'BIGINT', 'utf8mb4', 20, false, 0, null)
        );
        
        $result2 = new \Plasma\StreamQueryResult($command, 0, 1, null, $fields);
        $this->assertSame($fields, $result2->getFieldDefinitions());
    }
    
    function testGetRows() {
        $command = $this->getCommandMock();
        
        $result = new \Plasma\StreamQueryResult($command, 0, 1, null, null);
        $this->assertNull($result->getRows());
    }
    
    function testEvents() {
        $command = $this->getCommandMock();
        
        $events = array();
        
        $command
            ->method('once')
            ->will($this->returnCallback(function ($event, $cb) use (&$events) {
                $events[$event] = $cb;
            }));
    
        $command
            ->method('on')
            ->will($this->returnCallback(function ($event, $cb) use (&$events) {
                $events[$event] = $cb;
            }));
        
        $command
            ->method('emit')
            ->will($this->returnCallback(function ($event, $args) use (&$events) {
                $events[$event](...$args);
            }));
        
        $result = new \Plasma\StreamQueryResult($command, 0, 1, null, null);
        
        $deferred = new \React\Promise\Deferred();
        $result->once('end', array($deferred, 'resolve'));
        
        $command->emit('end', array());
        
        $this->assertNull($this->await($deferred->promise()));
    
        $result2 = new \Plasma\StreamQueryResult($command, 0, 1, null, null);
        
        $deferred3 = new \React\Promise\Deferred();
        $result2->once('error', array($deferred3, 'resolve'));
        
        $command->emit('error', array((new \RuntimeException('test'))));
        
        $exc = $this->await($deferred3->promise());
        $this->assertInstanceOf(\Throwable::class, $exc);
    }
    
    function testAll() {
        $command = $this->getCommandMock();
        
        $command
            ->method('once')
            ->will($this->returnCallback(function ($event, $cb) use (&$events) {
                $events[$event] = $cb;
            }));
        
        $command
            ->method('on')
            ->will($this->returnCallback(function ($event, $cb) use (&$events) {
                $events[$event] = $cb;
            }));
        
        $command
            ->method('emit')
            ->will($this->returnCallback(function ($event, $args) use (&$events) {
                $events[$event](...$args);
            }));
        
        $result = new \Plasma\StreamQueryResult($command, 0, 1, null, null);
        
        $prom = $result->all();
        $this->assertInstanceOf(\React\Promise\PromiseInterface::class, $prom);
        
        $command->emit('data', array(5));
        $command->emit('data', array(255));
        $command->emit('data', array(851));
        
        $command->emit('end');
        
        $result = $this->await($prom);
        $this->assertInstanceOf(\Plasma\QueryResultInterface::class, $result);
        
        $rows = $result->getRows();
        $this->assertSame(array(5, 255, 851), $rows);
    }
    
    function getCommandMock(): \Plasma\CommandInterface {
        return $this->getMockBuilder(\Plasma\CommandInterface::class)
            ->setMethods(array(
                'listeners',
                'on',
                'once',
                'emit',
                'removeListener',
                'removeAllListeners',
                'getEncodedMessage',
                'onComplete',
                'onError',
                'onNext',
                'hasFinished',
                'waitForCompletion'
            ))
            ->getMock();
    }
}
