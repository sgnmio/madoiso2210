<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Gson\Test\Unit\Internal\AccessorStrategy;

use Closure;
use PHPUnit\Framework\TestCase;
use Tebru\Gson\Internal\AccessorStrategy\GetByClosure;
use Tebru\Gson\Test\Mock\Unit\Internal\AccessorStrategy\GetByClosureTest\GetByClosureTestMock;
use Throwable;

/**
 * Class GetByClosureTest
 *
 * @author Nate Brunette <n@tebru.net>
 * @covers \Tebru\Gson\Internal\AccessorStrategy\GetByClosure
 */
class GetByClosureTest extends TestCase
{
    public function testGetter(): void
    {
        $strategy = new GetByClosure('foo', GetByClosureTestMock::class);

        self::assertSame('bar', $strategy->get(new GetByClosureTestMock()));
    }

    public function testGetterNoProperty(): void
    {
        $strategy = new GetByClosure('foobar', GetByClosureTestMock::class);

        try {
            $strategy->get(new GetByClosureTestMock());
        } catch (Throwable $throwable) {
            self::assertTrue(true);
            return;
        }
        self::assertTrue(false);
    }

    public function testGetterUsesCache(): void
    {
        $strategy = new GetByClosure('foo', GetByClosureTestMock::class);

        $strategy->get(new GetByClosureTestMock());

        $closure = Closure::bind(function () {
            return $this->getter;
        }, $strategy, GetByClosure::class);

        $getter = $closure();

        $strategy->get(new GetByClosureTestMock());

        $getter2 = $closure();

        self::assertSame($getter, $getter2);
    }
}
