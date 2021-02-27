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

use Plasma\CommandInterface;
use Plasma\QueryResultInterface;
use Plasma\StreamQueryResult;
use React\Promise\Deferred;
use React\Promise\PromiseInterface;

class StreamQueryResultTest extends ClientTestHelpers {
    function testGetAffectedRows() {
        $command = $this->getCommandMock();
        
        $result = new StreamQueryResult($command, 0, 1, null, null);
        self::assertSame(0, $result->getAffectedRows());
    }
    
    function testGetWarningsCount() {
        $command = $this->getCommandMock();
        
        $result = new StreamQueryResult($command, 0, 1, null, null);
        self::assertSame(1, $result->getWarningsCount());
    }
    
    function testGetInsertID() {
        $command = $this->getCommandMock();
        
        $result = new StreamQueryResult($command, 0, 1, null, null);
        self::assertNull($result->getInsertID());
        
        $result2 = new StreamQueryResult($command, 0, 1, 42, null);
        self::assertSame(42, $result2->getInsertID());
    }
    
    function testGetFieldDefinitions() {
        $command = $this->getCommandMock();
        
        $result = new StreamQueryResult($command, 0, 1, null, null);
        self::assertNull($result->getFieldDefinitions());
        
        $fields = array(
            $this->getColDefMock('test2', 'coltest', 'BIGINT', 'utf8mb4', 20, false, 0, null)
        );
        
        $result2 = new StreamQueryResult($command, 0, 1, null, $fields);
        self::assertSame($fields, $result2->getFieldDefinitions());
    }
    
    function testGetRows() {
        $command = $this->getCommandMock();
        
        $result = new StreamQueryResult($command, 0, 1, null, null);
        self::assertNull($result->getRows());
    }
    
    function testEvents() {
        $command = $this->getCommandMock();
        
        $events = array();
        
        $command
            ->method('once')
            ->willReturnCallback(
                function ($event, $cb) use (&$events) {
                    $events[$event] = $cb;
                }
            );
    
        $command
            ->method('on')
            ->willReturnCallback(
                function ($event, $cb) use (&$events) {
                    $events[$event] = $cb;
                }
            );
        
        $command
            ->method('emit')
            ->willReturnCallback(
                function ($event, $args) use (&$events) {
                    $events[$event](...$args);
                }
            );
        
        $result = new StreamQueryResult($command, 0, 1, null, null);
        
        $deferred = new Deferred();
        $result->once('end', array($deferred, 'resolve'));
        
        $command->emit('end', array());
        
        self::assertNull($this->await($deferred->promise()));
    
        $result2 = new StreamQueryResult($command, 0, 1, null, null);
        
        $deferred3 = new Deferred();
        $result2->once('error', array($deferred3, 'resolve'));
        
        $command->emit('error', array((new \RuntimeException('test'))));
        
        $exc = $this->await($deferred3->promise());
        self::assertInstanceOf(\Throwable::class, $exc);
    }
    
    function testAll() {
        $command = $this->getCommandMock();
        
        $command
            ->method('once')
            ->willReturnCallback(
                function ($event, $cb) use (&$events) {
                    $events[$event] = $cb;
                }
            );
        
        $command
            ->method('on')
            ->willReturnCallback(
                function ($event, $cb) use (&$events) {
                    $events[$event] = $cb;
                }
            );
        
        $command
            ->method('emit')
            ->willReturnCallback(
                function ($event, $args) use (&$events) {
                    $events[$event](...$args);
                }
            );
        
        $result = new StreamQueryResult($command, 0, 1, null, null);
        
        $prom = $result->all();
        self::assertInstanceOf(PromiseInterface::class, $prom);
        
        $command->emit('data', array(5));
        $command->emit('data', array(255));
        $command->emit('data', array(851));
        
        $command->emit('end');
        
        $result = $this->await($prom);
        self::assertInstanceOf(QueryResultInterface::class, $result);
        
        $rows = $result->getRows();
        self::assertSame(array(5, 255, 851), $rows);
    }
    
    function getCommandMock(): CommandInterface {
        return $this->getMockBuilder(CommandInterface::class)
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
