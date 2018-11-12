<?php
/**
 * Plasma Core component
 * Copyright 2018 PlasmaPHP, All Rights Reserved
 *
 * Website: https://github.com/PlasmaPHP
 * License: https://github.com/PlasmaPHP/core/blob/master/LICENSE
*/

namespace Plasma\Tests;

class StreamQueryResultTest extends ClientTestHelpers {
    function testGetAffectedRows() {
        $driver = $this->getDriverMock();
        $command = $this->getMockBuilder(\Plasma\CommandInterface::class)
            ->setMethods(array(
                'listeners',
                'on',
                'once',
                'emit',
                'removeListener',
                'removeAllListeners'
            ))
            ->getMock();
        
        $result = new \Plasma\StreamQueryResult($driver, $command, 0, 1, null, null);
        $this->assertSame(0, $result->getAffectedRows());
    }
    
    function testGetWarningsCount() {
        $driver = $this->getDriverMock();
        $command = $this->getMockBuilder(\Plasma\CommandInterface::class)
            ->setMethods(array(
                'listeners',
                'on',
                'once',
                'emit',
                'removeListener',
                'removeAllListeners'
            ))
            ->getMock();
        
        $result = new \Plasma\StreamQueryResult($driver, $command, 0, 1, null, null);
        $this->assertSame(1, $result->getWarningsCount());
    }
    
    function testGetFieldDefinitions() {
        $driver = $this->getDriverMock();
        $command = $this->getMockBuilder(\Plasma\CommandInterface::class)
            ->setMethods(array(
                'listeners',
                'on',
                'once',
                'emit',
                'removeListener',
                'removeAllListeners'
            ))
            ->getMock();
        
        $result = new \Plasma\StreamQueryResult($driver, $command, 0, 1, null, null);
        $this->assertNull($result->getFieldDefinitions());
        
        $fields = array(
            (new \Plasma\ColumnDefinition('test', 'test2', 'coltest', 'BIGINT', 'utf8mb4', 20, false, 0, null))
        );
        
        $result2 = new \Plasma\StreamQueryResult($driver, $command, 0, 1, $fields, null);
        $this->assertSame($fields, $result->getFieldDefinitions());
    }
    
    function testGetInsertID() {
        $driver = $this->getDriverMock();
        $command = $this->getMockBuilder(\Plasma\CommandInterface::class)
            ->setMethods(array(
                'listeners',
                'on',
                'once',
                'emit',
                'removeListener',
                'removeAllListeners'
            ))
            ->getMock();
        
        $result = new \Plasma\StreamQueryResult($driver, $command, 0, 1, null, null);
        $this->assertNull($result->getInsertID());
        
        $result2 = new \Plasma\StreamQueryResult($driver, $command, 0, 1, null, 42);
        $this->assertSame(42, $result2->getInsertID());
    }
    
    function testStream() {
        $driver = $this->getDriverMock();
        $command = $this->getMockBuilder(\Plasma\CommandInterface::class)
            ->setMethods(array(
                'listeners',
                'on',
                'once',
                'emit',
                'removeListener',
                'removeAllListeners'
            ))
            ->getMock();
        
        $result = new \Plasma\StreamQueryResult($driver, $command, 0, 1, null, null);
        
        $deferred = new \React\Promise\Deferred();
        
        $result->once('data', function ($val) use (&$deferred) {
            $deferred->resolve($val);
        });
        
        
    }
    
    function testIsReadable() {
        $driver = $this->getDriverMock();
        $command = $this->getMockBuilder(\Plasma\CommandInterface::class)
            ->getMock();
        
        $result = new \Plasma\StreamQueryResult($driver, $command, 0, 1, null, null);
        $this->assertTrue($result->isReadable());
        
        $result->close();
        $this->assertFalse($result->isReadable());
    }

    function testPause() {
        $driver = $this->getDriverMock();
        $command = $this->getMockBuilder(\Plasma\CommandInterface::class)
            ->setMethods(array(
                'listeners',
                'on',
                'once',
                'emit',
                'removeListener',
                'removeAllListeners'
            ))
            ->getMock();
        
        $events = array();
    
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
        
        $result = new \Plasma\StreamQueryResult($driver, $command, 0, 1, null, null);
        $this->assertTrue($result->isReadable());
        
        $deferred = new \React\Promise\Deferred();
        
        $result->once('data', function ($val) use (&$deferred) {
            $deferred->resolve($val);
        });
        
        $driver->emit('data', array(50));
        
        $value = $this->await($deferred->promise());
        $this->assertSame(50, $value);
        
        $driver
            ->expects($this->once())
            ->method('pauseStreamConsumption')
            ->will($this->returnValue(true));
        
        $this->assertNull($result->pause());
        
        $deferred2 = new \React\Promise\Deferred();
        
        $result->once('data', function ($val) use (&$deferred2) {
            $deferred2->resolve($val);
        });
        
        $driver->emit('data', array(50));
        
        try {
            $this->await($deferred2->promise(), 0.1);
            throw new \Exception('Unexpected data emit');
        } catch (\Throwable $e) {
            $this->assertInstanceOf(\React\Promise\Timer\TimeoutException::class, $e);
        }
        
        $command2 = $this->getMockBuilder(\Plasma\CommandInterface::class)
            ->setMethods(array(
                'listeners',
                'on',
                'once',
                'emit',
                'removeListener',
                'removeAllListeners'
            ))
            ->getMock();
        
        $events2 = array();
        $driver2 = $this->getDriverMock();
        
        $driver2
            ->expects($this->once())
            ->method('pauseStreamConsumption')
            ->will($this->returnValue(true));
    
        $command2
            ->method('on')
            ->will($this->returnCallback(function ($event, $cb) use (&$events2) {
                $events2[$event] = $cb;
            }));
        
        $command2
            ->method('emit')
            ->will($this->returnCallback(function ($event, $args) use (&$events2) {
                $events2[$event](...$args);
            }));
        
        $result = new \Plasma\StreamQueryResult($driver2, $command2, 0, 1, null, null);
        $deferred3 = new \React\Promise\Deferred();
        
        $result2->once('data', function ($val) use (&$deferred3) {
            $deferred3->resolve($val);
        });
        
        $driver2->emit('data', array(25));
        
        $value2 = $this->await($deferred3->promise());
        $this->assertSame(25, $value2);
        
        $this->assertNull($driver2->pause());
        
        $deferred4 = new \React\Promise\Deferred();
        
        $result2->once('data', function ($val) use (&$deferred4) {
            $deferred4->resolve($val);
        });
        
        $driver2->emit('data', array(252));
        
        $value3 = $this->await($deferred4->promise());
        $this->assertSame(252, $value3);
    }

    function testResume() {
        $driver = $this->getDriverMock();
        $command = $this->getMockBuilder(\Plasma\CommandInterface::class)
            ->setMethods(array(
                'listeners',
                'on',
                'once',
                'emit',
                'removeListener',
                'removeAllListeners'
            ))
            ->getMock();
        
        $result = new \Plasma\StreamQueryResult($driver, $command, 0, 1, null, null);
        $events = array();
    
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
        
        $driver
            ->expects($this->once())
            ->method('pauseStreamConsumption')
            ->will($this->returnValue(true));
        
        $this->assertNull($result->pause());
        
        $driver
            ->expects($this->once())
            ->method('resumeStreamConsumption')
            ->will($this->returnValue(true));
        
        $this->assertNull($result->resume());
    }

    function testPipe(WritableStreamInterface $dest, array $options = array()) {
        /*
         -- Not implemented yet --
        */
    }
    
    function testClose() {
        $driver = $this->getDriverMock();
        $command = $this->getMockBuilder(\Plasma\CommandInterface::class)
            ->setMethods(array(
                'listeners',
                'on',
                'once',
                'emit',
                'removeListener',
                'removeAllListeners'
            ))
            ->getMock();
        
        $result = new \Plasma\StreamQueryResult($driver, $command, 0, 1, null, null);
        
        $deferred = new \React\Promise\Deferred();
        
        $result->once('close', function () use (&$deferred) {
            $deferred->resolve();
        });
        
        $this->assertTrue($result->isReadable());
        $this->assertNull($result->close());
        
        $this->assertFalse($result->isReadable());
        $this->assertNull($this->await($deferred->promise()));
    }
}