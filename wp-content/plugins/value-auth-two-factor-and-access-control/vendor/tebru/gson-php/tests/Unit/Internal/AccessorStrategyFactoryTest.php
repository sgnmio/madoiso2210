<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Gson\Test\Unit\Internal;

use PHPUnit\Framework\TestCase;
use ReflectionMethod;
use ReflectionProperty;
use Tebru\Gson\Internal\AccessorStrategy\GetByClosure;
use Tebru\Gson\Internal\AccessorStrategy\GetByMethod;
use Tebru\Gson\Internal\AccessorStrategy\GetByPublicProperty;
use Tebru\Gson\Internal\AccessorStrategy\SetByClosure;
use Tebru\Gson\Internal\AccessorStrategy\SetByMethod;
use Tebru\Gson\Internal\AccessorStrategy\SetByPublicProperty;
use Tebru\Gson\Internal\AccessorStrategyFactory;
use Tebru\Gson\Test\Mock\ChildClass;

/**
 * Class AccessorStrategyFactoryTest
 *
 * @author Nate Brunette <n@tebru.net>
 * @covers \Tebru\Gson\Internal\AccessorStrategyFactory
 */
class AccessorStrategyFactoryTest extends TestCase
{
    public function testGetterWithMethod(): void
    {
        $property = new ReflectionProperty(ChildClass::class, 'foo');
        $method = new ReflectionMethod(ChildClass::class, 'isFoo');

        $factory = new AccessorStrategyFactory();
        $strategy = $factory->getterStrategy($property, $method);

        self::assertInstanceOf(GetByMethod::class, $strategy);
    }

    public function testGetterWithProperty(): void
    {
        $property = new ReflectionProperty(ChildClass::class, 'overridden');

        $factory = new AccessorStrategyFactory();
        $strategy = $factory->getterStrategy($property);

        self::assertInstanceOf(GetByPublicProperty::class, $strategy);
    }

    public function testGetterWithClosure(): void
    {
        $property = new ReflectionProperty(ChildClass::class, 'foo');

        $factory = new AccessorStrategyFactory();
        $strategy = $factory->getterStrategy($property);

        self::assertInstanceOf(GetByClosure::class, $strategy);
    }

    public function testSetterWithMethod(): void
    {
        $property = new ReflectionProperty(ChildClass::class, 'foo');
        $method = new ReflectionMethod(ChildClass::class, 'setFoo');

        $factory = new AccessorStrategyFactory();
        $strategy = $factory->setterStrategy($property, $method);

        self::assertInstanceOf(SetByMethod::class, $strategy);
    }

    public function testSetterWithProperty(): void
    {
        $property = new ReflectionProperty(ChildClass::class, 'overridden');

        $factory = new AccessorStrategyFactory();
        $strategy = $factory->setterStrategy($property);

        self::assertInstanceOf(SetByPublicProperty::class, $strategy);
    }

    public function testSetterWithClosure(): void
    {
        $property = new ReflectionProperty(ChildClass::class, 'foo');

        $factory = new AccessorStrategyFactory();
        $strategy = $factory->setterStrategy($property);

        self::assertInstanceOf(SetByClosure::class, $strategy);
    }
}
