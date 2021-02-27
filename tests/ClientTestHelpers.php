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

use Plasma\AbstractColumnDefinition;
use Plasma\Client;
use Plasma\ClientInterface;
use Plasma\ColumnDefinitionInterface;
use Plasma\DriverFactoryInterface;
use Plasma\DriverInterface;
use function React\Promise\resolve;

abstract class ClientTestHelpers extends TestCase {
    /**
     * @var DriverFactoryInterface
     */
    public $factory;
    
    /**
     * @var DriverInterface
     */
    public $driver;
    
    function createClient(array $options = array()): ClientInterface {
        $this->factory = $this->getMockBuilder(DriverFactoryInterface::class)
            ->setMethods(array(
                'createDriver',
            ))
            ->getMock();
        
        $this->driver = $this->getDriverMock();
        
        $this->driver
            ->method('getConnectionState')
            ->willReturn(DriverInterface::CONNECTION_OK);
        
        $this->driver
            ->method('connect')
            ->with('localhost')
            ->willReturn(resolve());
        
        $events = array();
        
        $this->driver
            ->method('on')
            ->willReturnCallback(
                function ($event, $cb) use (&$events) {
                    $events[$event] = $cb;
                }
            );
        
        $this->driver
            ->method('emit')
            ->willReturnCallback(
                function ($event, $args) use (&$events) {
                    $events[$event](...$args);
                }
            );
        
        $this->factory
            ->method('createDriver')
            ->willReturn($this->driver);
        
        return Client::create($this->factory, 'localhost', $options);
    }
    
    function createClientMock(): ClientInterface {
        return $this->getMockBuilder(ClientInterface::class)
            ->setMethods(array(
                'getConnectionCount',
                'beginTransaction',
                'checkinConnection',
                'close',
                'quit',
                'runCommand',
                'runQuery'
            ))
            ->getMock();
    }
    
    function getDriverMock(): DriverInterface {
        return $this->getMockBuilder(DriverInterface::class)
            ->setMethods(array(
                'getConnectionState',
                'getBusyState',
                'getBacklogLength',
                'connect',
                'pauseStreamConsumption',
                'resumeStreamConsumption',
                'close',
                'quit',
                'isInTransaction',
                'query',
                'prepare',
                'execute',
                'quote',
                'beginTransaction',
                'endTransaction',
                'runCommand',
                'runQuery',
                'createReadCursor',
                'listeners',
                'on',
                'once',
                'emit',
                'removeListener',
                'removeAllListeners'
            ))
            ->getMock();
    }
    
    function getColDefMock(...$args): ColumnDefinitionInterface {
        return $this->getMockBuilder(AbstractColumnDefinition::class)
            ->setMethods(array(
                'isNullable',
                'isAutoIncrement',
                'isPrimaryKey',
                'isUniqueKey',
                'isMultipleKey',
                'isUnsigned',
                'isZerofilled'
            ))
            ->setConstructorArgs($args)
            ->getMockForAbstractClass();
    }
}
