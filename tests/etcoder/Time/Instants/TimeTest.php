<?php

declare(strict_types=1);

/**
 * This file is part of the etcoder/Time package.
 *
 * Evgeniy Tkachenko <et.coder@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace etcoder\Time\Instants;

use etcoder\Time\Instants\Interfaces\Instant;
use PHPUnit\Framework\TestCase;

class TimeTest extends TestCase
{
    public function testInstant()
    {
        $time = TimePoint::builder()->todayByMinute(00, 00);
        $this->assertInstanceOf(Instant::class, $time);

        $this->assertEquals(23, $time->previous(1)->hour());
        $this->assertEquals(59, $time->previous(1)->minute());
        $this->assertEquals(59, $time->previous(1)->second());

        $this->assertEquals(0, $time->next(1)->hour());
        $this->assertEquals(0, $time->next(1)->minute());
        $this->assertEquals(01, $time->next(1)->second());

        $time = TimePoint::builder()->todayByMinute(24, 00);
        $this->assertInstanceOf(Instant::class, $time);

        $this->assertEquals(23, $time->previous(1)->hour());
        $this->assertEquals(59, $time->previous(1)->minute());
        $this->assertEquals(59, $time->previous(1)->second());

        $this->assertEquals(0, $time->next(1)->hour());
        $this->assertEquals(0, $time->next(1)->minute());
        $this->assertEquals(01, $time->next(1)->second());

        $time = TimePoint::builder()->todayByMinute(23, 59);
        $this->assertInstanceOf(Instant::class, $time);

        $this->assertEquals(0, $time->next(60)->hour());
        $this->assertEquals(0, $time->next(60)->minute());
        $this->assertEquals(01, $time->next(60)->second());
    }

    public function testCompare()
    {
        $time = TimePoint::builder()->todayByMinute(00, 00);
        $otherTime = TimePoint::builder()->todayByMinute(24, 00);

        $this->assertFalse($time->compareTo($otherTime)->isEqual());
        $this->assertFalse($time->compareTo($otherTime)->isMore());
        $this->assertFalse($time->compareTo($otherTime)->isNotLess());
        $this->assertTrue($time->compareTo($otherTime)->isNotEqual());
        $this->assertTrue($time->compareTo($otherTime)->isNotMore());
        $this->assertTrue($time->compareTo($otherTime)->isLess());

        $time = TimePoint::builder()->todayByMinute(00, 00);
        $otherTime = new TimePoint($time->day()->previous(), 24, 0, 0);

        $this->assertTrue($time->compareTo($otherTime)->isEqual());
        $this->assertFalse($time->compareTo($otherTime)->isMore());
        $this->assertTrue($time->compareTo($otherTime)->isNotLess());
        $this->assertFalse($time->compareTo($otherTime)->isNotEqual());
        $this->assertTrue($time->compareTo($otherTime)->isNotMore());
        $this->assertFalse($time->compareTo($otherTime)->isLess());

        $time = TimePoint::builder()->todayByMinute(24, 00);
        $otherTime = new TimePoint($time->day()->next(), 00, 0, 0);

        $this->assertTrue($time->compareTo($otherTime)->isEqual());
        $this->assertFalse($time->compareTo($otherTime)->isMore());
        $this->assertTrue($time->compareTo($otherTime)->isNotLess());
        $this->assertFalse($time->compareTo($otherTime)->isNotEqual());
        $this->assertTrue($time->compareTo($otherTime)->isNotMore());
        $this->assertFalse($time->compareTo($otherTime)->isLess());
    }
}
