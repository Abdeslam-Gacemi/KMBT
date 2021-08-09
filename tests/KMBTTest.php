<?php

/**
* @author Abdeslam Gacemi <abdobling@gmail.com>
*/

namespace Tests;

use Abdeslam\KMBT\KMBT;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class KMBTTest extends TestCase
{
    public function test_KMBT_formatForK()
    {
        $this->assertSame('0.11K', KMBT::formatForK(110));
        $this->assertSame('0.04K', KMBT::formatForK(37));
        $this->assertSame('1.23K', KMBT::formatForK(1230));
        $this->assertSame('1.24 K', KMBT::formatForK(1238, 2, false, ' '));
        $this->assertSame('1.2-K', KMBT::formatForK(1238, 1, false, '-'));
        $this->assertSame('1K', KMBT::formatForK(1000, 1));
        $this->assertSame('0.04 thousand', KMBT::formatForK(37, 2, true, ' '));
        $this->assertSame('1 thousand', KMBT::formatForK(1000, 2, true, ' '));
        $this->assertSame('1.2 thousand', KMBT::formatForK(1238, 1, true, ' '));
        $this->assertSame('2.4 thousands', KMBT::formatForK(2380, 1, true, ' '));
    }

    public function test_KMBT_formatForM()
    {
        $this->assertSame('0.11M', KMBT::formatForM(110000));
        $this->assertSame('0.04M', KMBT::formatForM(37000));
        $this->assertSame('1.23M', KMBT::formatForM(1230000));
        $this->assertSame('1.24 M', KMBT::formatForM(1238000, 2, false, ' '));
        $this->assertSame('1.2-M', KMBT::formatForM(1238000, 1, false, '-'));
        $this->assertSame('1M', KMBT::formatForM(1000000, 1));
        $this->assertSame('0.04 million', KMBT::formatForM(37000, 2, true, ' '));
        $this->assertSame('1 million', KMBT::formatForM(1000000, 2, true, ' '));
        $this->assertSame('1.2 million', KMBT::formatForM(1238000, 1, true, ' '));
        $this->assertSame('2.3 millions', KMBT::formatForM(2298000, 1, true, ' '));
    }

    public function test_KMBT_formatForB()
    {
        $this->assertSame('0.11B', KMBT::formatForB(11 * (10**7)));
        $this->assertSame('0.04B', KMBT::formatForB(37 * (10**6)));
        $this->assertSame('1.23B', KMBT::formatForB(123 * (10**7)));
        $this->assertSame('1.24 B', KMBT::formatForB(1238 * (10**6), 2, false, ' '));
        $this->assertSame('1.2-B', KMBT::formatForB(1238 * (10**6), 1, false, '-'));
        $this->assertSame('1B', KMBT::formatForB(1 * (10**9), 1));
        $this->assertSame('0.04 billion', KMBT::formatForB(37 * (10**6), 2, true, ' '));
        $this->assertSame('1 billion', KMBT::formatForB(1 * (10**9), 2, true, ' '));
        $this->assertSame('1.2 billion', KMBT::formatForB(1238 * (10**6), 1, true, ' '));
        $this->assertSame('2.3 billions', KMBT::formatForB(2298 * (10**6), 1, true, ' '));
    }

    public function test_KMBT_formatForT()
    {
        $this->assertSame('0.11T', KMBT::formatForT(11 * (10**10)));
        $this->assertSame('0.04T', KMBT::formatForT(37 * (10**9)));
        $this->assertSame('1.23T', KMBT::formatForT(123 * (10**10)));
        $this->assertSame('1.24 T', KMBT::formatForT(1238 * (10**9), 2, false, ' '));
        $this->assertSame('1.2-T', KMBT::formatForT(1238 * (10**9), 1, false, '-'));
        $this->assertSame('1T', KMBT::formatForT(1 * (10**12), 1));
        $this->assertSame('0.04 trillion', KMBT::formatForT(37 * (10**9), 2, true, ' '));
        $this->assertSame('1 trillion', KMBT::formatForT(1 * (10**12), 2, true, ' '));
        $this->assertSame('1.2 trillion', KMBT::formatForT(1238 * (10**9), 1, true, ' '));
        $this->assertSame('2.3 trillions', KMBT::formatForT(2298 * (10**9), 1, true, ' '));
    }

    public function test_KMBT_validateNumber_throwsException()
    {
        $this->expectException(InvalidArgumentException::class);
        KMBT::formatForK('hello');
    }

    public function test_KMBT_convertToNumber()
    {
        // k - thousand
        $this->assertEquals(12300, KMBT::convertToNumber('12.3K'));
        $this->assertEquals(300, KMBT::convertToNumber('.3K'));
        $this->assertEquals(300, KMBT::convertToNumber('0.3K'));
        $this->assertEquals(12300, KMBT::convertToNumber('12.3 thousands'));
        $this->assertEquals(1300, KMBT::convertToNumber('1.3 thousand'));
        // m - million
        $this->assertEquals(12300000, KMBT::convertToNumber('12.3M'));
        $this->assertEquals(300000, KMBT::convertToNumber('.3M'));
        $this->assertEquals(300000, KMBT::convertToNumber('0.3M'));
        $this->assertEquals(12300000, KMBT::convertToNumber('12.3 millions'));
        $this->assertEquals(1300000, KMBT::convertToNumber('1.3 million'));
        // b - billion
        $this->assertEquals(123 * (10**8), KMBT::convertToNumber('12.3B'));
        $this->assertEquals(3 * (10**8), KMBT::convertToNumber('0.3B'));
        $this->assertEquals(3 * (10**8), KMBT::convertToNumber('.3B'));
        $this->assertEquals(123 * (10**8), KMBT::convertToNumber('12.3 billions'));
        $this->assertEquals(13 * (10**8), KMBT::convertToNumber('1.3 billion'));
        // t - trillion
        $this->assertEquals(123 * (10**11), KMBT::convertToNumber('12.3T'));
        $this->assertEquals(3 * (10**11), KMBT::convertToNumber('.3T'));
        $this->assertEquals(3 * (10**11), KMBT::convertToNumber('0.3T'));
        $this->assertEquals(123 * (10**11), KMBT::convertToNumber('12.3 trillions'));
        $this->assertEquals(13 * (10**11), KMBT::convertToNumber('1.3 trillion'));
    }

    public function test_KMBT_addFormula()
    {
        KMBT::addFormula('H', 'hundred', 10**2);
        $this->assertSame('1H', KMBT::formatForH(100));
        $this->assertSame('1 hundred', KMBT::formatForH(100, 2, true, ' '));
        $this->assertSame('2.3H', KMBT::formatForH(230, 1));
        $this->assertSame('2.3 hundreds', KMBT::formatForH(230, 1, true, ' '));
        // throws exception when overriding base formulas (k, m, b, t)
        $this->expectException(InvalidArgumentException::class);
        KMBT::addFormula('K', 'thousand', 10**3);
    }

    public function test_KMBT_pluralize()
    {
        $reflect = new ReflectionClass(KMBT::class);
        $method = $reflect->getMethod('pluralize');
        $method->setAccessible(true);
        $this->assertSame('bugs', $method->invokeArgs(null, ['bug']));
        $this->assertSame('cities', $method->invokeArgs(null, ['city']));
        $this->assertSame('matches', $method->invokeArgs(null, ['match']));
        $this->assertSame('fishes', $method->invokeArgs(null, ['fish']));
        $this->assertSame('boxes', $method->invokeArgs(null, ['box']));
        $this->assertSame('buses', $method->invokeArgs(null, ['bus']));
        $method->setAccessible(false);
    }
}
