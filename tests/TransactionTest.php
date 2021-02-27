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

use Plasma\DriverInterface;
use Plasma\Exception;
use Plasma\QueryBuilderInterface;
use Plasma\Transaction;
use Plasma\TransactionException;
use Plasma\TransactionInterface;
use React\Promise\PromiseInterface;
use function React\Promise\reject;
use function React\Promise\resolve;

class TransactionTest extends ClientTestHelpers {
    function testConstruct() {
        $client = $this->createClient(array('connections.lazy' => true));
        $driver = $this->getDriverMock();
        
        $transaction = new Transaction($client, $driver, TransactionInterface::ISOLATION_UNCOMMITTED);
        self::assertInstanceOf(TransactionInterface::class, $transaction);
    }
    
    function testConstruct2() {
        $client = $this->createClient(array('connections.lazy' => true));
        $driver = $this->getDriverMock();
        
        $transaction = new Transaction($client, $driver, TransactionInterface::ISOLATION_COMMITTED);
        self::assertInstanceOf(TransactionInterface::class, $transaction);
    }
    
    function testConstruct3() {
        $client = $this->createClient(array('connections.lazy' => true));
        $driver = $this->getDriverMock();
        
        $transaction = new Transaction($client, $driver, TransactionInterface::ISOLATION_REPEATABLE);
        self::assertInstanceOf(TransactionInterface::class, $transaction);
    }
    
    function testConstruct4() {
        $client = $this->createClient(array('connections.lazy' => true));
        $driver = $this->getDriverMock();
        
        $transaction = new Transaction($client, $driver, TransactionInterface::ISOLATION_SERIALIZABLE);
        self::assertInstanceOf(TransactionInterface::class, $transaction);
    }
    
    function testConstructFail() {
        $client = $this->createClient(array('connections.lazy' => true));
        $driver = $this->getDriverMock();
        
        $this->expectException(Exception::class);
        $transaction = new Transaction($client, $driver, 250);
    }
    
    function testDestruct() {
        $client = $this->createClient(array('connections.lazy' => true));
        $driver = $this->getDriverMock();
        
        $driver->expects(self::atMost(2))
            ->method('getConnectionState')
            ->willReturn(DriverInterface::CONNECTION_OK);
        
        $driver->expects(self::once())
            ->method('query')
            ->with($client, 'ROLLBACK')
            ->willReturn(resolve());
        
        (static function ($client, $driver) {
            $transaction = new Transaction($client, $driver, TransactionInterface::ISOLATION_UNCOMMITTED);
        })($client, $driver);
    }
    
    function testDestructFail() {
        $client = $this->createClient(array('connections.lazy' => true));
        $driver = $this->getDriverMock();
        
        $driver->expects(self::atMost(2))
            ->method('getConnectionState')
            ->willReturn(DriverInterface::CONNECTION_OK);
        
        $driver->expects(self::once())
            ->method('query')
            ->with($client, 'ROLLBACK')
            ->willReturn(reject((new \RuntimeException('test'))));
        
        $driver->expects(self::once())
            ->method('close')
            ->willReturn(resolve());
        
        (static function ($client, $driver) {
            $transaction = new Transaction($client, $driver, TransactionInterface::ISOLATION_UNCOMMITTED);
        })($client, $driver);
    }
    
    function testGetIsolationLevel() {
        $client = $this->createClient(array('connections.lazy' => true));
        $driver = $this->getDriverMock();
        
        $transaction = new Transaction($client, $driver, TransactionInterface::ISOLATION_SERIALIZABLE);
        self::assertSame(TransactionInterface::ISOLATION_SERIALIZABLE, $transaction->getIsolationLevel());
    }
    
    function testIsActive() {
        $client = $this->createClient(array('connections.lazy' => true));
        $driver = $this->getDriverMock();
        
        $transaction = new Transaction($client, $driver, TransactionInterface::ISOLATION_SERIALIZABLE);
        self::assertTrue($transaction->isActive());
    }
    
    function testIsActiveFalse() {
        $client = $this->createClient(array('connections.lazy' => true));
        $driver = $this->getDriverMock();
        
        $transaction = new Transaction($client, $driver, TransactionInterface::ISOLATION_SERIALIZABLE);
        
        $driver->expects(self::once())
            ->method('query')
            ->with($client, 'ROLLBACK')
            ->willReturn(resolve());
        
        $prom = $transaction->rollback();
        self::assertInstanceOf(PromiseInterface::class, $prom);
        
        $this->await($prom);
        self::assertFalse($transaction->isActive());
    }
    
    function testCommit() {
        $client = $this->createClient(array('connections.lazy' => true));
        $driver = $this->getDriverMock();
        
        $transaction = new Transaction($client, $driver, TransactionInterface::ISOLATION_SERIALIZABLE);
        
        $driver->expects(self::once())
            ->method('query')
            ->with($client, 'COMMIT')
            ->willReturn(resolve());
        
        $prom = $transaction->commit();
        self::assertInstanceOf(PromiseInterface::class, $prom);
        
        $this->await($prom);
    }
    
    function testRollback() {
        $client = $this->createClient(array('connections.lazy' => true));
        $driver = $this->getDriverMock();
        
        $transaction = new Transaction($client, $driver, TransactionInterface::ISOLATION_SERIALIZABLE);
        
        $driver->expects(self::once())
            ->method('query')
            ->with($client, 'ROLLBACK')
            ->willReturn(resolve());
        
        $prom = $transaction->rollback();
        self::assertInstanceOf(PromiseInterface::class, $prom);
        
        $this->await($prom);
    }
    
    function testCreateSavepoint() {
        $client = $this->createClient(array('connections.lazy' => true));
        $driver = $this->getDriverMock();
        
        $transaction = new Transaction($client, $driver, TransactionInterface::ISOLATION_SERIALIZABLE);
        
        $driver->expects(self::once())
            ->method('quote')
            ->with('hello')
            ->willReturn('"hello"');
        
        $driver->expects(self::once())
            ->method('query')
            ->with($client, 'SAVEPOINT "hello"')
            ->willReturn(resolve());
        
        $prom = $transaction->createSavepoint('hello');
        self::assertInstanceOf(PromiseInterface::class, $prom);
        
        $this->await($prom);
    }
    
    function testRollbackTo() {
        $client = $this->createClient(array('connections.lazy' => true));
        $driver = $this->getDriverMock();
        
        $transaction = new Transaction($client, $driver, TransactionInterface::ISOLATION_SERIALIZABLE);
        
        $driver->expects(self::once())
            ->method('quote')
            ->with('hello')
            ->willReturn('"hello"');
        
        $driver->expects(self::once())
            ->method('query')
            ->with($client, 'ROLLBACK TO "hello"')
            ->willReturn(resolve());
        
        $prom = $transaction->rollbackTo('hello');
        self::assertInstanceOf(PromiseInterface::class, $prom);
        
        $this->await($prom);
    }
    
    function testReleaseSavepoint() {
        $client = $this->createClient(array('connections.lazy' => true));
        $driver = $this->getDriverMock();
        
        $transaction = new Transaction($client, $driver, TransactionInterface::ISOLATION_SERIALIZABLE);
        
        $driver->expects(self::once())
            ->method('quote')
            ->with('hello')
            ->willReturn('"hello"');
        
        $driver->expects(self::once())
            ->method('query')
            ->with($client, 'RELEASE SAVEPOINT "hello"')
            ->willReturn(resolve());
        
        $prom = $transaction->releaseSavepoint('hello');
        self::assertInstanceOf(PromiseInterface::class, $prom);
        
        $this->await($prom);
    }
    
    function testPrepare() {
        $client = $this->createClient(array('connections.lazy' => true));
        $driver = $this->getDriverMock();
        
        $transaction = new Transaction($client, $driver, TransactionInterface::ISOLATION_SERIALIZABLE);
        
        $driver->expects(self::once())
            ->method('prepare')
            ->with($client, 'SELECT 1')
            ->willReturn(resolve());
        
        $prom = $transaction->prepare('SELECT 1');
        self::assertInstanceOf(PromiseInterface::class, $prom);
        
        $this->await($prom);
    }
    
    function testPrepareFail() {
        $client = $this->createClient(array('connections.lazy' => true));
        $driver = $this->getDriverMock();
        
        $transaction = new Transaction($client, $driver, TransactionInterface::ISOLATION_SERIALIZABLE);
        
        $driver->expects(self::once())
            ->method('query')
            ->with($client, 'COMMIT')
            ->willReturn(resolve());
        
        $prom = $transaction->commit();
        self::assertInstanceOf(PromiseInterface::class, $prom);
        
        $this->await($prom);
        
        $driver->expects(self::never())
            ->method('prepare')
            ->with($client, 'SELECT 1')
            ->willReturn(resolve());
        
        $this->expectException(TransactionException::class);
        $prom2 = $transaction->prepare('SELECT 1');
    }
    
    function testQuery() {
        $client = $this->createClient(array('connections.lazy' => true));
        $driver = $this->getDriverMock();
        
        $transaction = new Transaction($client, $driver, TransactionInterface::ISOLATION_SERIALIZABLE);
        
        $driver->expects(self::once())
            ->method('query')
            ->with($client, 'SELECT 1')
            ->willReturn(resolve());
        
        $prom = $transaction->query('SELECT 1');
        self::assertInstanceOf(PromiseInterface::class, $prom);
        
        $this->await($prom);
    }
    
    function testQueryFail() {
        $client = $this->createClient(array('connections.lazy' => true));
        $driver = $this->getDriverMock();
        
        $transaction = new Transaction($client, $driver, TransactionInterface::ISOLATION_SERIALIZABLE);
        
        $driver->expects(self::once())
            ->method('query')
            ->with($client, 'COMMIT')
            ->willReturn(resolve());
        
        $prom = $transaction->commit();
        self::assertInstanceOf(PromiseInterface::class, $prom);
        
        $this->await($prom);
        
        $driver->expects(self::never())
            ->method('query')
            ->with($client, 'SELECT 1')
            ->willReturn(resolve());
        
        $this->expectException(TransactionException::class);
        $prom2 = $transaction->query('SELECT 1');
    }
    
    function testExecute() {
        $client = $this->createClient(array('connections.lazy' => true));
        $driver = $this->getDriverMock();
        
        $transaction = new Transaction($client, $driver, TransactionInterface::ISOLATION_SERIALIZABLE);
        
        $driver->expects(self::once())
            ->method('execute')
            ->with($client, 'SELECT 1')
            ->willReturn(resolve());
        
        $prom = $transaction->execute('SELECT 1');
        self::assertInstanceOf(PromiseInterface::class, $prom);
        
        $this->await($prom);
    }
    
    function testExecuteFail() {
        $client = $this->createClient(array('connections.lazy' => true));
        $driver = $this->getDriverMock();
        
        $transaction = new Transaction($client, $driver, TransactionInterface::ISOLATION_SERIALIZABLE);
        
        $driver->expects(self::once())
            ->method('query')
            ->with($client, 'COMMIT')
            ->willReturn(resolve());
        
        $prom = $transaction->commit();
        self::assertInstanceOf(PromiseInterface::class, $prom);
        
        $this->await($prom);
        
        $driver->expects(self::never())
            ->method('execute')
            ->with($client, 'SELECT 1')
            ->willReturn(resolve());
        
        $this->expectException(TransactionException::class);
        $prom2 = $transaction->execute('SELECT 1');
    }
    
    function testRunQuery() {
        $client = $this->createClient(array('connections.lazy' => true));
        $driver = $this->getDriverMock();
        
        $transaction = new Transaction($client, $driver, TransactionInterface::ISOLATION_SERIALIZABLE);
        
        $qb = $this->getMockBuilder(QueryBuilderInterface::class)
            ->setMethods(array(
                'create',
                'getQuery',
                'getParameters'
            ))
            ->getMock();
        
        $driver->expects(self::once())
            ->method('runQuery')
            ->with($client, $qb)
            ->willReturn(resolve());
        
        $prom = $transaction->runQuery($qb);
        self::assertInstanceOf(PromiseInterface::class, $prom);
        
        $this->await($prom);
    }
    
    function testRunQueryFail() {
        $client = $this->createClient(array('connections.lazy' => true));
        $driver = $this->getDriverMock();
        
        $transaction = new Transaction($client, $driver, TransactionInterface::ISOLATION_SERIALIZABLE);
        
        $driver->expects(self::once())
            ->method('query')
            ->with($client, 'COMMIT')
            ->willReturn(resolve());
        
        $prom = $transaction->commit();
        self::assertInstanceOf(PromiseInterface::class, $prom);
        
        $this->await($prom);
        
        $qb = $this->getMockBuilder(QueryBuilderInterface::class)
            ->setMethods(array(
                'create',
                'getQuery',
                'getParameters'
            ))
            ->getMock();
        
        $driver->expects(self::never())
            ->method('runQuery')
            ->with($client, $qb)
            ->willReturn(resolve());
        
        $this->expectException(TransactionException::class);
        $prom2 = $transaction->runQuery($qb);
    }
    
    function testQuote() {
        $client = $this->createClient(array('connections.lazy' => true));
        $driver = $this->getDriverMock();
        
        $transaction = new Transaction($client, $driver, TransactionInterface::ISOLATION_SERIALIZABLE);
        
        $driver->expects(self::once())
            ->method('quote')
            ->with('COMMIT')
            ->willReturn('"COMMIT"');
        
        $quoted = $transaction->quote('COMMIT');
        self::assertIsString($quoted);
    }
    
    function testQuoteFail() {
        $client = $this->createClient(array('connections.lazy' => true));
        $driver = $this->getDriverMock();
        
        $transaction = new Transaction($client, $driver, TransactionInterface::ISOLATION_SERIALIZABLE);
        
        $driver->expects(self::once())
            ->method('query')
            ->with($client, 'COMMIT')
            ->willReturn(resolve());
        
        $prom = $transaction->commit();
        self::assertInstanceOf(PromiseInterface::class, $prom);
        
        $this->await($prom);
        
        $driver->expects(self::never())
            ->method('quote')
            ->with('COMMIT')
            ->willReturn('"COMMIT"');
        
        $this->expectException(TransactionException::class);
        $quoted = $transaction->quote('COMMIT');
    }
}
