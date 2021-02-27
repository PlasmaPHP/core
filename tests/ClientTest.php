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
use Plasma\DriverInterface;
use Plasma\Exception;
use Plasma\QueryBuilderInterface;
use Plasma\QueryResult;
use Plasma\QueryResultInterface;
use Plasma\StatementInterface;
use Plasma\TransactionInterface;
use React\Promise\Deferred;
use React\Promise\PromiseInterface;
use function React\Promise\reject;
use function React\Promise\resolve;

class ClientTest extends ClientTestHelpers {
    function testNewConnectionEvent() {
        $client = $this->createClient();
        
        $this->driver
            ->expects(self::once())
            ->method('connect')
            ->with('localhost')
            ->willReturn(resolve());
        
        $this->driver
            ->expects(self::once())
            ->method('prepare')
            ->willReturn(resolve());
        
        $this->driver
            ->method('getBacklogLength')
            ->willReturn(1);
        
        $deferred = new Deferred();
        
        $client->once('newConnection', function ($driver) use (&$deferred) {
            $this->assertInstanceOf(DriverInterface::class, $driver);
            $deferred->resolve();
        });
        
        $client->prepare('SELECT 1');
        self::assertNull($this->await($deferred->promise()));
    }
    
    function testCloseEvent() {
        $client = $this->createClient();
        
        $deferred = new Deferred();
        
        $client->once('close', function ($driver) use (&$deferred) {
            $this->assertInstanceOf(DriverInterface::class, $driver);
            $deferred->resolve();
        });
        
        $this->driver->emit('close', array());
        self::assertNull($this->await($deferred->promise()));
    }
    
    function testErrorEvent() {
        $client = $this->createClient();
        
        $deferred = new Deferred();
        
        $client->once('error', function ($error, $driver) use (&$deferred) {
            $this->assertInstanceOf(\Throwable::class, $error);
            $this->assertInstanceOf(DriverInterface::class, $driver);
            
            $deferred->resolve();
        });
        
        $this->driver->emit('error', array((new \RuntimeException('hello'))));
        self::assertNull($this->await($deferred->promise()));
    }
    
    function testEventRelayEvent() {
        $client = $this->createClient();
        
        $deferred = new Deferred();
        
        $client->once('test', function ($a, $driver) use (&$deferred) {
            $this->assertInstanceOf(\stdClass::class, $a);
            $this->assertInstanceOf(DriverInterface::class, $driver);
            
            $deferred->resolve();
        });
        
        $this->driver->emit('eventRelay', array('test', (new \stdClass())));
        self::assertNull($this->await($deferred->promise()));
    }
    
    function testGetConnectionCount() {
        $client = $this->createClient();
        self::assertSame(1, $client->getConnectionCount());
    }
    
    function testGetConnectionCountLazy() {
        $client = $this->createClient(array('connections.lazy' => true));
        self::assertSame(0, $client->getConnectionCount());
    }
    
    function testBeginTransaction() {
        $client = $this->createClient();
        
        $trans = $this->getMockBuilder(TransactionInterface::class)
            ->getMock();
        
        $this->driver
            ->expects(self::once())
            ->method('beginTransaction')
            ->with($client, TransactionInterface::ISOLATION_SERIALIZABLE)
            ->willReturn(resolve($trans));
        
        $prom = $client->beginTransaction(TransactionInterface::ISOLATION_SERIALIZABLE);
        self::assertInstanceof(PromiseInterface::class, $prom);
        
        $transaction = $this->await($prom);
        self::assertInstanceOf(TransactionInterface::class, $transaction);
    }
    
    function testBeginTransactionDriverError() {
        $client = $this->createClient();
        
        $this->driver
            ->expects(self::once())
            ->method('beginTransaction')
            ->willReturn(reject((new Exception('test'))));
        
        $prom = $client->beginTransaction(TransactionInterface::ISOLATION_SERIALIZABLE);
        self::assertInstanceof(PromiseInterface::class, $prom);
        
        $this->expectException(Exception::class);
        $this->await($prom);
    }
    
    function testBeginTransactionGoingAway() {
        $client = $this->createClient();
        
        self::assertNull($client->quit());
        
        $prom = $client->beginTransaction(TransactionInterface::ISOLATION_SERIALIZABLE);
        self::assertInstanceof(PromiseInterface::class, $prom);
        
        $this->expectException(Exception::class);
        $this->await($prom);
    }
    
    function testCheckinConnection() {
        $client = $this->createClient();
        
        $this->driver->emit('close', array());
        
        self::assertSame(0, $client->getConnectionCount());
        
        $this->factory
            ->expects(self::once())
            ->method('createDriver')
            ->willReturn($this->driver);
        
        $newDriver = $this->getDriverMock();
        
        $newDriver
            ->method('getConnectionState')
            ->willReturn(DriverInterface::CONNECTION_UNUSABLE);
        
        $client->checkinConnection($newDriver);
        self::assertSame(0, $client->getConnectionCount());
        
        $newDriver2 = $this->factory->createDriver();
        $client->checkinConnection($newDriver2);
        
        self::assertSame(1, $client->getConnectionCount());
    }
    
    function testClose() {
        $client = $this->createClient();
        
        $this->driver
            ->expects(self::once())
            ->method('close')
            ->willReturn(resolve());
        
        $prom = $client->close();
        self::assertInstanceOf(PromiseInterface::class, $prom);
        
        self::assertNull($client->quit());
    }
    
    function testCloseBusy() {
        $client = $this->createClient();
        
        $this->driver
            ->method('query')
            ->willReturn(resolve());
        
        $client->query('SELECT 1');
        
        $this->driver
            ->expects(self::once())
            ->method('close')
            ->willReturn(resolve());
        
        $prom = $client->close();
        self::assertInstanceOf(PromiseInterface::class, $prom);
    }
    
    function testQuit() {
        $client = $this->createClient();
        
        $this->driver
            ->expects(self::once())
            ->method('quit');
        
        self::assertNull($client->quit());
        self::assertInstanceOf(PromiseInterface::class, $client->close());
        
        $client->checkinConnection($this->factory->createDriver());
        self::assertSame(0, $client->getConnectionCount());
    }
    
    function testQuitBusy() {
        $client = $this->createClient();
        
        $this->driver
            ->expects(self::once())
            ->method('quit');
        
        $this->driver
            ->method('query')
            ->willReturn(resolve());
        
        $client->query('SELECT 1');
        
        self::assertNull($client->quit());
    }
    
    function testQuery() {
        $client = $this->createClient();
        
        $this->driver
            ->expects(self::once())
            ->method('query')
            ->with($client, 'SELECT 1')
            ->willReturn(resolve((new QueryResult(0, 0, null, null, null))));
        
        $prom = $client->query('SELECT 1');
        self::assertInstanceOf(PromiseInterface::class, $prom);
        
        $result = $this->await($prom);
        self::assertInstanceOf(QueryResultInterface::class, $result);
    }
    
    function testQueryDriverError() {
        $client = $this->createClient();
        
        $this->driver
            ->expects(self::once())
            ->method('query')
            ->willReturn(reject((new Exception('test'))));
        
        $prom = $client->query('SELECT 1');
        self::assertInstanceof(PromiseInterface::class, $prom);
        
        $this->expectException(Exception::class);
        $this->await($prom);
    }
    
    function testQueryGoingAway() {
        $client = $this->createClient();
        
        self::assertNull($client->quit());
        
        $prom = $client->query('SELECT 1');
        self::assertInstanceof(PromiseInterface::class, $prom);
        
        $this->expectException(Exception::class);
        $this->await($prom);
    }
    
    function testPrepare() {
        $client = $this->createClient();
        
        $statement = $this->getMockBuilder(StatementInterface::class)
            ->getMock();
        
        $this->driver
            ->expects(self::once())
            ->method('prepare')
            ->with($client, 'SELECT 1')
            ->willReturn(resolve($statement));
        
        $prom = $client->prepare('SELECT 1');
        self::assertInstanceOf(PromiseInterface::class, $prom);
        
        $result = $this->await($prom);
        self::assertInstanceOf(StatementInterface::class, $result);
    }
    
    function testPrepareDriverError() {
        $client = $this->createClient();
        
        $this->driver
            ->expects(self::once())
            ->method('prepare')
            ->willReturn(reject((new Exception('test'))));
        
        $prom = $client->prepare('SELECT 1');
        self::assertInstanceof(PromiseInterface::class, $prom);
        
        $this->expectException(Exception::class);
        $this->await($prom);
    }
    
    function testPrepareGoingAway() {
        $client = $this->createClient();
        
        self::assertNull($client->quit());
        
        $prom = $client->prepare('SELECT 1');
        self::assertInstanceof(PromiseInterface::class, $prom);
        
        $this->expectException(Exception::class);
        $this->await($prom);
    }
    
    function testExecute() {
        $client = $this->createClient();
        
        $this->driver
            ->expects(self::once())
            ->method('execute')
            ->with($client, 'SELECT 1')
            ->willReturn(resolve((new QueryResult(0, 0, null, null, null))));
        
        $prom = $client->execute('SELECT 1');
        self::assertInstanceOf(PromiseInterface::class, $prom);
        
        $result = $this->await($prom);
        self::assertInstanceOf(QueryResultInterface::class, $result);
    }
    
    function testExecuteDriverError() {
        $client = $this->createClient();
        
        $this->driver
            ->expects(self::once())
            ->method('execute')
            ->willReturn(reject((new Exception('test'))));
        
        $prom = $client->execute('SELECT 1');
        self::assertInstanceof(PromiseInterface::class, $prom);
        
        $this->expectException(Exception::class);
        $this->await($prom);
    }
    
    function testExecuteGoingAway() {
        $client = $this->createClient();
        
        self::assertNull($client->quit());
        
        $prom = $client->execute('SELECT 1');
        self::assertInstanceof(PromiseInterface::class, $prom);
        
        $this->expectException(Exception::class);
        $this->await($prom);
    }
    
    function testQuote() {
        $client = $this->createClient();
        
        $this->driver
            ->expects(self::once())
            ->method('quote')
            ->with('Hel"lo')
            ->willReturn('Hel\"lo');
        
        self::assertSame('Hel\"lo', $client->quote('Hel"lo'));
    }
    
    function testQuoteGoingAway() {
        $client = $this->createClient();
        
        self::assertNull($client->quit());
        
        $this->expectException(Exception::class);
        $client->quote('Hel"lo');
    }
    
    function testRunCommand() {
        $client = $this->createClient();
        
        $command = $this->getMockBuilder(CommandInterface::class)
            ->getMock();
        
        $this->driver
            ->expects(self::once())
            ->method('runCommand')
            ->with($client, $command)
            ->willReturn(true);
        
        self::assertTrue($client->runCommand($command));
    }
    
    function testRunCommandGoingAway() {
        $client = $this->createClient();
        
        self::assertNull($client->quit());
        
        $command = $this->getMockBuilder(CommandInterface::class)
            ->getMock();
        
        $this->expectException(Exception::class);
        $client->runCommand($command);
    }
    
    function testRunQuery() {
        $client = $this->createClient();
        
        $query = $this->getMockBuilder(QueryBuilderInterface::class)
            ->getMock();
        
        $this->driver
            ->expects(self::once())
            ->method('runQuery')
            ->with($client, $query)
            ->willReturn(resolve());
        
        $promise = $client->runQuery($query);
        self::assertInstanceOf(PromiseInterface::class, $promise);
    }
    
    function testRunQueryGoingAway() {
        $client = $this->createClient();
        
        self::assertNull($client->quit());
        
        $query = $this->getMockBuilder(QueryBuilderInterface::class)
            ->getMock();
        
        $promise = $client->runQuery($query);
        self::assertInstanceOf(PromiseInterface::class, $promise);
        
        $this->expectException(Exception::class);
        $this->await($promise);
    }
    
    function testCreateReadCursor() {
        $client = $this->createClient();
        
        $query = 'SELECT 1';
        
        $this->driver
            ->expects(self::once())
            ->method('createReadCursor')
            ->with($client, $query, array())
            ->willReturn(resolve());
        
        $promise = $client->createReadCursor('SELECT 1', array());
        self::assertInstanceOf(PromiseInterface::class, $promise);
    }
    
    function testCreateReadCursorGoingAway() {
        $client = $this->createClient();
        
        self::assertNull($client->quit());
        
        $promise = $client->createReadCursor('SELECT 1', array());
        self::assertInstanceOf(PromiseInterface::class, $promise);
        
        $this->expectException(Exception::class);
        $this->await($promise);
    }
    
    function testLazyCreateConnection() {
        $client = $this->createClient(array('connections.lazy' => true));
        
        $command = $this->getMockBuilder(CommandInterface::class)
            ->getMock();
        
        $this->driver
            ->expects(self::once())
            ->method('runCommand')
            ->with($client, $command)
            ->willReturn(true);
        
        self::assertTrue($client->runCommand($command));
    }
}
