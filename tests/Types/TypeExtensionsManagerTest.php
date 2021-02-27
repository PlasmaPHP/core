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

use Plasma\ColumnDefinitionInterface;
use Plasma\Exception;
use Plasma\Tests\ClientTestHelpers;
use Plasma\Types\AbstractTypeExtension;
use Plasma\Types\TypeExtensionResult;
use Plasma\Types\TypeExtensionResultInterface;
use Plasma\Types\TypeExtensionsManager;

class TypeExtensionsManagerTest extends ClientTestHelpers {
    function testGetManager() {
        self::assertNull(TypeExtensionsManager::registerManager(__FUNCTION__));
        
        $manager = TypeExtensionsManager::getManager(__FUNCTION__);
        self::assertInstanceOf(TypeExtensionsManager::class, $manager);
    }
    
    function testGetManagerFail() {
        $this->expectException(Exception::class);
        self::assertNull(TypeExtensionsManager::getManager(__FUNCTION__));
    }
    
    function testGetManagerGlobal() {
        $manager = TypeExtensionsManager::getManager();
        self::assertInstanceOf(TypeExtensionsManager::class, $manager);
    }
    
    function testGetManagerGlobalNoFail() {
        self::assertNull(TypeExtensionsManager::unregisterManager(TypeExtensionsManager::GLOBAL_NAME));
        
        $manager = TypeExtensionsManager::getManager();
        self::assertInstanceOf(TypeExtensionsManager::class, $manager);
    }
    
    function testRegisterManager() {
        $man = new TypeExtensionsManager();
        self::assertNull(TypeExtensionsManager::registerManager(__FUNCTION__, $man));
        
        $manager = TypeExtensionsManager::getManager(__FUNCTION__);
        self::assertInstanceOf(TypeExtensionsManager::class, $manager);
        
        self::assertSame($man, $manager);
    }
    
    function testRegisterManagerFail() {
        $man = new TypeExtensionsManager();
        self::assertNull(TypeExtensionsManager::registerManager(__FUNCTION__, $man));
        
        $manager = TypeExtensionsManager::getManager(__FUNCTION__);
        self::assertInstanceOf(TypeExtensionsManager::class, $manager);
        
        self::assertSame($man, $manager);
        
        $this->expectException(Exception::class);
        self::assertNull(TypeExtensionsManager::registerManager(__FUNCTION__, $man));
    }
    
    function testUnregisterManager() {
        self::assertNull(TypeExtensionsManager::registerManager(__FUNCTION__));
        
        self::assertNull(TypeExtensionsManager::unregisterManager(__FUNCTION__));
        
        try {
            self::assertInstanceOf(\Throwable::class, TypeExtensionsManager::getManager(__FUNCTION__));
        } catch (Exception $e) {
            self::assertInstanceOf(Exception::class, $e);
        }
        
        self::assertNull(TypeExtensionsManager::unregisterManager(__FUNCTION__));
    }
    
    function testRegisterType() {
        $manager = new TypeExtensionsManager();
        
        $type = (new class('string', 0xFB, 'is_string') extends AbstractTypeExtension {
            function encode($value, ColumnDefinitionInterface $col): TypeExtensionResultInterface {
                return (new TypeExtensionResult($this->getDatabaseType(), false, ((string) $value)));
            }
            function decode($value): TypeExtensionResultInterface {
                return (new TypeExtensionResult('string', false, ((string) $value)));
            }
        });
        
        self::assertNull($manager->registerType('string', $type));
        
        $encoded = $manager->encodeType('hello', $this->getColDefMock('world', 'a', 'b', 'c', 0, false, 0, null));
        self::assertInstanceOf(TypeExtensionResultInterface::class, $encoded);
    }
    
    function testRegisterTypeFail() {
        $manager = new TypeExtensionsManager();
        
        $type = (new class('string', 0xFB, 'is_string') extends AbstractTypeExtension {
            function encode($value, ColumnDefinitionInterface $col): TypeExtensionResultInterface {}
            function decode($value): TypeExtensionResultInterface {}
        });
        
        self::assertNull($manager->registerType('string', $type));
        
        $this->expectException(Exception::class);
        $manager->registerType('string', $type);
    }
    
    function testUnregisterType() {
        $manager = new TypeExtensionsManager();
        
        $type = (new class('string', 0xFB, 'is_string') extends AbstractTypeExtension {
            function encode($value, ColumnDefinitionInterface $col): TypeExtensionResultInterface {
                return (new TypeExtensionResult($this->getDatabaseType(), false, ((string) $value)));
            }
            function decode($value): TypeExtensionResultInterface {
                return (new TypeExtensionResult('string', false, ((string) $value)));
            }
        });
        
        self::assertNull($manager->registerType('string', $type));
        
        $encoded = $manager->encodeType('hello', $this->getColDefMock('world', 'a', 'b', 'c', 0, false, 0, null));
        self::assertInstanceOf(TypeExtensionResultInterface::class, $encoded);
        
        self::assertNull($manager->unregisterType('string'));
        
        try {
            self::assertInstanceOf(\Throwable::class, $manager->encodeType('hello', $this->getColDefMock('world', 'a', 'b', 'c', 0, false, 0, null)));
        } catch (Exception $e) {
            /* Continue */
        }
        
        // Check double unregister
        self::assertNull($manager->unregisterType('string'));
    }
    
    function testUnregisterUnknownType() {
        $manager = new TypeExtensionsManager();
        
        self::assertNull($manager->unregisterType('string'));
    }
    
    function testRegisterDatabaseType() {
        $manager = new TypeExtensionsManager();
        
        $type = (new class('string', 0xFB, 'is_string') extends AbstractTypeExtension {
            function encode($value, ColumnDefinitionInterface $col): TypeExtensionResultInterface {
                return (new TypeExtensionResult($this->getDatabaseType(), false, ((string) $value)));
            }
            function decode($value): TypeExtensionResultInterface {
                return (new TypeExtensionResult('string', false, ((string) $value)));
            }
        });
        
        self::assertNull($manager->registerDatabaseType(0xFB, $type));
        
        $decoded = $manager->decodeType(0xFB, 500);
        
        self::assertInstanceOf(TypeExtensionResultInterface::class, $decoded);
        self::assertsame('500', $decoded->getValue());
    }
    
    function testRegisterDatabaseTypeFail() {
        $manager = new TypeExtensionsManager();
        
        $type = (new class('string', 0xFB, 'is_string') extends AbstractTypeExtension {
            function encode($value, ColumnDefinitionInterface $col): TypeExtensionResultInterface {}
            function decode($value): TypeExtensionResultInterface {}
        });
        
        self::assertNull($manager->registerDatabaseType(0xFB, $type));
        
        $this->expectException(Exception::class);
        $manager->registerDatabaseType(0xFB, $type);
    }
    
    function testUnregisterDatabaseType() {
        $manager = new TypeExtensionsManager();
        
        $type = (new class('string', 0xFB, function () { return true; }) extends AbstractTypeExtension {
            function encode($value, ColumnDefinitionInterface $col): TypeExtensionResultInterface {
                return (new TypeExtensionResult($this->getDatabaseType(), false, ((string) $value)));
            }
            function decode($value): TypeExtensionResultInterface {
                return (new TypeExtensionResult('string', false, ((string) $value)));
            }
        });
        
        self::assertNull($manager->registerDatabaseType(0xFB, $type));
        
        $decoded = $manager->decodeType(null, true);
        
        self::assertInstanceOf(TypeExtensionResultInterface::class, $decoded);
        self::assertSame('1', $decoded->getValue());
        
        self::assertNull($manager->unregisterDatabaseType(0xFB));
        
        try {
            self::assertInstanceOf(\Throwable::class, $manager->decodeType(null, 'hello'));
        } catch (Exception $e) {
            self::assertInstanceOf(Exception::class, $e);
        }
        
        // Check double unregister
        self::assertNull($manager->unregisterDatabaseType(0xFB));
    }
    
    function testUnregisterDatabaseUnknownType() {
        $manager = new TypeExtensionsManager();
        
        try {
            self::assertInstanceOf(\Throwable::class, $manager->decodeType(null, 'hello'));
        } catch (Exception $e) {
            self::assertInstanceOf(Exception::class, $e);
        }
        
        self::assertNull($manager->unregisterDatabaseType(0xFB));
        
        // Check double unregister
        self::assertNull($manager->unregisterDatabaseType(0xFB));
    }
    
    function testEnableFuzzySearch() {
        $manager = new TypeExtensionsManager();
        
        self::assertNull($manager->disableFuzzySearch());
        
        try {
            self::assertInstanceOf(\Throwable::class, $manager->decodeType(null, 'hello'));
        } catch (Exception $e) {
            /* Assertion passed */
        }
        
        $type = (new class('string', 0xFB, 'is_string') extends AbstractTypeExtension {
            function encode($value, ColumnDefinitionInterface $col): TypeExtensionResultInterface {}
            function decode($value): TypeExtensionResultInterface {
                return (new TypeExtensionResult('string', false, true));
            }
        });
        
        self::assertNull($manager->registerDatabaseType(0xFB, $type));
        
        self::assertNull($manager->enableFuzzySearch());
        self::assertTrue($manager->decodeType(0xFB, 'hello')->getValue());
    }
    
    function testDisableFuzzySearch() {
        $manager = new TypeExtensionsManager();
        
        self::assertNull($manager->disableFuzzySearch());
        
        $type = (new class('string', 0xFB, function () {
            throw new \RuntimeException('canHandleType invoked');
         }) extends AbstractTypeExtension {
            function encode($value, ColumnDefinitionInterface $col): TypeExtensionResultInterface {}
            function decode($value): TypeExtensionResultInterface {
                return (new TypeExtensionResult('string', false, true));
            }
        });
        
        self::assertNull($manager->registerDatabaseType(0xFB, $type));
        
        $this->expectException(Exception::class);
        self::assertTrue($manager->decodeType(null, 'hello'));
    }
    
    function testEncodeType() {
        $manager = new TypeExtensionsManager();
        
        $type = (new class('string', 0xFE, 'is_string') extends AbstractTypeExtension {
            function encode($value, ColumnDefinitionInterface $col): TypeExtensionResultInterface {
                return (new TypeExtensionResult('string', false, \pack('C*', $value)));
            }
            
            function decode($value): TypeExtensionResultInterface {}
        });
        
        $manager->registerType('string', $type);
        
        $encoded = $manager->encodeType('hello it is me', $this->getColDefMock('world', 'a', 'b', 'c', 0, false, 0, null));
        
        self::assertInstanceOf(TypeExtensionResultInterface::class, $encoded);
        self::assertSame(\pack('C*', 'hello it is me'), $encoded->getValue());
    }
    
    function testDecodeType() {
        $manager = new TypeExtensionsManager();
        
        $type = (new class('string', 0xFE, function ($a, $b) {
            return \is_string($a);
        }) extends AbstractTypeExtension {
            function encode($value, ColumnDefinitionInterface $col): TypeExtensionResultInterface {}
            
            function decode($value): TypeExtensionResultInterface {
                return (new TypeExtensionResult('string', false, \unpack('C*', $value)));
            }
        });
        
        $manager->registerDatabaseType(0xFE, $type);
        
        $decoded = $manager->decodeType(0xFE, \pack('C*', 0, 20, 15, 30));
        
        self::assertInstanceOf(TypeExtensionResultInterface::class, $decoded);
        self::assertSame(array(0, 20, 15, 30), \array_values($decoded->getValue()));
        
        $decoded2 = $manager->decodeType(null, \pack('C*', 0, 20, 15, 30));
        
        self::assertInstanceOf(TypeExtensionResultInterface::class, $decoded2);
        self::assertSame(array(0, 20, 15, 30), \array_values($decoded2->getValue()));
    }
    
    function testEncodeTypeClass() {
        $manager = new TypeExtensionsManager();
        
        $type = (new class('string', 0xFE, function ($value) {
            return ($value instanceof \stdClass);
        }) extends AbstractTypeExtension {
            function encode($value, ColumnDefinitionInterface $col): TypeExtensionResultInterface {
                return (new TypeExtensionResult('json', false, \json_encode($value)));
            }
            
            function decode($value): TypeExtensionResultInterface {
                return (new TypeExtensionResult('json', false, \json_decode($value, true)));
            }
        });
        
        $manager->registerType(\JsonSerializable::class, $type);
        
        $class = (new class() implements \JsonSerializable {
            function jsonSerialize() {
                return array('hello' => true);
            }
        });
        
        $encoded = $manager->encodeType($class, $this->getColDefMock('world', 'a', 'b', 'c', 0, false, 0, null));
        
        self::assertInstanceOf(TypeExtensionResultInterface::class, $encoded);
        self::assertSame(\json_encode(array('hello' => true)), $encoded->getValue());
        
        $class = new \stdClass();
        $class->hello = true;
        
        $encoded2 = $manager->encodeType($class, $this->getColDefMock('world', 'a', 'b', 'c', 0, false, 0, null));
        
        self::assertInstanceOf(TypeExtensionResultInterface::class, $encoded2);
        self::assertSame(\json_encode(array('hello' => true)), $encoded2->getValue());
    }
    
    function testDecodeTypeClass() {
        $manager = new TypeExtensionsManager();
        
        $type = (new class('string', 0xFE, function ($a, $b) {
            return \is_string($a);
        }) extends AbstractTypeExtension {
            function encode($value, ColumnDefinitionInterface $col): TypeExtensionResultInterface {
                return (new TypeExtensionResult('json', false, \json_encode($value)));
            }
            
            function decode($value): TypeExtensionResultInterface {
                return (new TypeExtensionResult('json', false, \json_decode($value, true)));
            }
        });
        
        $manager->registerDatabaseType(0xFE, $type);
        
        $decoded = $manager->decodeType(0xFE, \json_encode(array('hello' => true)));
        
        self::assertInstanceOf(TypeExtensionResultInterface::class, $decoded);
        self::assertSame(array('hello' => true), $decoded->getValue());
        
        $decoded2 = $manager->decodeType(null, \json_encode(array('hello' => true)));
        
        self::assertInstanceOf(TypeExtensionResultInterface::class, $decoded2);
        self::assertSame(array('hello' => true), $decoded2->getValue());
    }
}
