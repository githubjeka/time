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
        $time = Time::builder()->today(00, 00);
        $this->assertInstanceOf(Instant::class, $time);

        $this->assertEquals(23, $time->previous(1)->hour());
        $this->assertEquals(59, $time->previous(1)->minute());
        $this->assertEquals(59, $time->previous(1)->second());

        $this->assertEquals(0, $time->next(1)->hour());
        $this->assertEquals(0, $time->next(1)->minute());
        $this->assertEquals(01, $time->next(1)->second());

        $time = Time::builder()->today(24, 00);
        $this->assertInstanceOf(Instant::class, $time);

        $this->assertEquals(23, $time->previous(1)->hour());
        $this->assertEquals(59, $time->previous(1)->minute());
        $this->assertEquals(59, $time->previous(1)->second());

        $this->assertEquals(0, $time->next(1)->hour());
        $this->assertEquals(0, $time->next(1)->minute());
        $this->assertEquals(01, $time->next(1)->second());

        $time = Time::builder()->today(23, 59);
        $this->assertInstanceOf(Instant::class, $time);

        $this->assertEquals(0, $time->next(60)->hour());
        $this->assertEquals(0, $time->next(60)->minute());
        $this->assertEquals(01, $time->next(60)->second());

        $time = Time::builder()->midnightDay(Day::builder()->today());
        $this->assertInstanceOf(Instant::class, $time);

        $this->assertEquals(0, $time->hour());
        $this->assertEquals(0, $time->minute());
        $this->assertEquals(0, $time->second());

        $day = Day::builder()->byIntParams(2020, 12, 31);
        $time = Time::builder()->endDay($day);
        $this->assertInstanceOf(Instant::class, $time);

        $this->assertEquals(31, $time->day()->number());
        $this->assertEquals(12, $time->day()->month()->number());
        $this->assertEquals(2020, $time->day()->month()->year()->number());
        $this->assertEquals(24, $time->hour());
        $this->assertEquals(0, $time->minute());
        $this->assertEquals(0, $time->second());

        $time = Time::builder()->forDay($day)->time(15, 23);
        $this->assertEquals(31, $time->day()->number());
        $this->assertEquals(12, $time->day()->month()->number());
        $this->assertEquals(2020, $time->day()->month()->year()->number());
        $this->assertEquals(15, $time->hour());
        $this->assertEquals(23, $time->minute());
        $this->assertEquals(0, $time->second());

        $time = Time::builder()->byDatetime(\DateTimeImmutable::createFromFormat('Y-m-d H:i:s','2021-01-14 10:15:00'));
        $this->assertEquals(14, $time->day()->number());
        $this->assertEquals(1, $time->day()->month()->number());
        $this->assertEquals(2021, $time->day()->month()->year()->number());
        $this->assertEquals(10, $time->hour());
        $this->assertEquals(15, $time->minute());
        $this->assertEquals(0, $time->second());
    }

    public function testCompare()
    {
        $time = Time::builder()->today(00, 00);
        $otherTime = Time::builder()->today(24, 00);

        $this->assertFalse($time->compareTo($otherTime)->isEqual());
        $this->assertFalse($time->compareTo($otherTime)->isMore());
        $this->assertFalse($time->compareTo($otherTime)->isNotLess());
        $this->assertTrue($time->compareTo($otherTime)->isNotEqual());
        $this->assertTrue($time->compareTo($otherTime)->isNotMore());
        $this->assertTrue($time->compareTo($otherTime)->isLess());

        $time = Time::builder()->today(00, 00);
        $otherTime = new Time($time->day()->previous(), 24, 0, 0);

        $this->assertTrue($time->compareTo($otherTime)->isEqual());
        $this->assertFalse($time->compareTo($otherTime)->isMore());
        $this->assertTrue($time->compareTo($otherTime)->isNotLess());
        $this->assertFalse($time->compareTo($otherTime)->isNotEqual());
        $this->assertTrue($time->compareTo($otherTime)->isNotMore());
        $this->assertFalse($time->compareTo($otherTime)->isLess());

        $time = Time::builder()->today(24, 00);
        $otherTime = new Time($time->day()->next(), 00, 0, 0);

        $this->assertTrue($time->compareTo($otherTime)->isEqual());
        $this->assertFalse($time->compareTo($otherTime)->isMore());
        $this->assertTrue($time->compareTo($otherTime)->isNotLess());
        $this->assertFalse($time->compareTo($otherTime)->isNotEqual());
        $this->assertTrue($time->compareTo($otherTime)->isNotMore());
        $this->assertFalse($time->compareTo($otherTime)->isLess());

        $time = Time::builder()->midnightDay(Day::builder()->today());
        $otherTime = Time::builder()->midnightDay(Day::builder()->today()->next());

        $this->assertFalse($time->compareTo($otherTime)->isEqual());
        $this->assertFalse($time->compareTo($otherTime)->isMore());
        $this->assertFalse($time->compareTo($otherTime)->isNotLess());
        $this->assertTrue($time->compareTo($otherTime)->isNotEqual());
        $this->assertTrue($time->compareTo($otherTime)->isNotMore());
        $this->assertTrue($time->compareTo($otherTime)->isLess());

        $time = Time::builder()->midnightDay(Day::builder()->byIntParams(2021, 1, 1));
        $otherTime = Time::builder()->midnightDay(Day::builder()->byIntParams(2021, 1, 4));

        $this->assertFalse($otherTime->compareTo($time)->isEqual());
        $this->assertTrue($otherTime->compareTo($time)->isMore());
        $this->assertTrue($otherTime->compareTo($time)->isNotLess());
        $this->assertTrue($otherTime->compareTo($time)->isNotEqual());
        $this->assertFalse($otherTime->compareTo($time)->isNotMore());
        $this->assertFalse($otherTime->compareTo($time)->isLess());

        $time = Time::builder()->today(16, 00);
        $otherTime = Time::builder()->today(17, 00);

        $this->assertFalse($time->compareTo($otherTime)->isEqual());
        $this->assertFalse($otherTime->compareTo($time)->isEqual());

        $this->assertTrue($time->compareTo($otherTime)->isNotEqual());
        $this->assertTrue($otherTime->compareTo($time)->isNotEqual());

        $this->assertFalse($time->compareTo($otherTime)->isMore());
        $this->assertTrue($otherTime->compareTo($time)->isMore());

        $this->assertTrue($time->compareTo($otherTime)->isNotMore());
        $this->assertFalse($otherTime->compareTo($time)->isNotMore());

        $this->assertTrue($time->compareTo($otherTime)->isLess());
        $this->assertFalse($otherTime->compareTo($time)->isLess());

        $this->assertFalse($time->compareTo($otherTime)->isNotLess());
        $this->assertTrue($otherTime->compareTo($time)->isNotLess());

        $time = Time::builder()->today(16, 01);
        $otherTime = Time::builder()->today(16, 02);

        $this->assertFalse($time->compareTo($otherTime)->isEqual());
        $this->assertFalse($otherTime->compareTo($time)->isEqual());

        $this->assertTrue($time->compareTo($otherTime)->isNotEqual());
        $this->assertTrue($otherTime->compareTo($time)->isNotEqual());

        $this->assertFalse($time->compareTo($otherTime)->isMore());
        $this->assertTrue($otherTime->compareTo($time)->isMore());

        $this->assertTrue($time->compareTo($otherTime)->isNotMore());
        $this->assertFalse($otherTime->compareTo($time)->isNotMore());

        $this->assertTrue($time->compareTo($otherTime)->isLess());
        $this->assertFalse($otherTime->compareTo($time)->isLess());

        $this->assertFalse($time->compareTo($otherTime)->isNotLess());
        $this->assertTrue($otherTime->compareTo($time)->isNotLess());
    }
}
