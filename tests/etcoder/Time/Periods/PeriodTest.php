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

namespace etcoder\Time\Periods;

use etcoder\Time\Instants\Hour;
use etcoder\Time\Instants\Minute;
use etcoder\Time\Instants\Month;
use etcoder\Time\Instants\Time;
use PHPUnit\Framework\TestCase;

class PeriodTest extends TestCase
{
    public function testBuilder()
    {
        $currentMonth = Month::builder()->now();
        $period = Period::builder()->byMonth($currentMonth);

        $this->assertTrue($currentMonth->compareTo($period->monthScale()->start())->isEqual());
        $this->assertTrue($currentMonth->compareTo($period->monthScale()->end())->isEqual());

        $this->assertTrue($currentMonth->year()->compareTo($period->yearScale()->start())->isEqual());
        $this->assertTrue($currentMonth->year()->compareTo($period->yearScale()->end())->isEqual());

        $this->assertTrue($currentMonth->days()->first()->compareTo($period->dayScale()->start())->isEqual());
        $this->assertTrue($currentMonth->days()->last()->compareTo($period->dayScale()->end())->isEqual());

        $period = new Period(Time::builder()->today(12, 10), Time::builder()->today(13, 15));

        $this->assertSame(12, $period->hourScale()->start()->value());
        $this->assertSame(13, $period->hourScale()->end()->value());
        $this->assertSame(10, $period->minuteScale()->start()->value());
        $this->assertSame(15, $period->minuteScale()->end()->value());
        $this->assertSame(0, $period->secondScale()->start()->second());
        $this->assertSame(0, $period->secondScale()->end()->second());
    }

    public function testPositionsBefore()
    {
        $month = Month::builder()->byIntParams(2021, 01);
        $period = Period::builder()->byMonth($month);

        $day = $month->previous()->days()->first();

        $points = [
            $day,
            Time::builder()->forDay($day)->time(00, 0),
            Minute::builder()->midnightDay($day),
            Hour::builder()->midnightDay($day),
        ];

        foreach ($points as $point) {
            $this->assertTrue($period->relativeTo($point)->instantIsBefore());
            $this->assertFalse($period->relativeTo($point)->instantIsNotBefore());
            $this->assertFalse($period->relativeTo($point)->periodIsBefore());
            $this->assertTrue($period->relativeTo($point)->periodIsNotBefore());
            $this->assertFalse($period->relativeTo($point)->instantIsAfter());
            $this->assertTrue($period->relativeTo($point)->instantIsNotAfter());
            $this->assertTrue($period->relativeTo($point)->periodIsAfter());
            $this->assertFalse($period->relativeTo($point)->periodIsNotAfter());
            $this->assertFalse($period->relativeTo($point)->contain());
            $this->assertTrue($period->relativeTo($point)->notContain());
            $this->assertFalse($period->relativeTo($point)->atStart());
            $this->assertTrue($period->relativeTo($point)->notAtStart());
            $this->assertFalse($period->relativeTo($point)->atBound());
            $this->assertTrue($period->relativeTo($point)->notAtBound());
            $this->assertFalse($period->relativeTo($point)->atEnd());
            $this->assertTrue($period->relativeTo($point)->notAtEnd());
            $this->assertFalse($period->relativeTo($point)->isBetween());
            $this->assertTrue($period->relativeTo($point)->isNotBetween());
        }
    }

    public function testPositionsAtStart()
    {
        $month = Month::builder()->byIntParams(2021, 01);
        $period = Period::builder()->byMonth($month);

        $day = $month->days()->first();

        $points = [
            $day,
            Time::builder()->forDay($day)->time(00, 0),
            Minute::builder()->midnightDay($day),
            Hour::builder()->midnightDay($day),
        ];

        foreach ($points as $point) {
            $this->assertFalse($period->relativeTo($point)->instantIsBefore());
            $this->assertTrue($period->relativeTo($point)->instantIsNotBefore());
            $this->assertFalse($period->relativeTo($point)->periodIsBefore());
            $this->assertTrue($period->relativeTo($point)->periodIsNotBefore());
            $this->assertFalse($period->relativeTo($point)->instantIsAfter());
            $this->assertTrue($period->relativeTo($point)->instantIsNotAfter());
            $this->assertFalse($period->relativeTo($point)->periodIsAfter());
            $this->assertTrue($period->relativeTo($point)->periodIsNotAfter());
            $this->assertTrue($period->relativeTo($point)->contain());
            $this->assertFalse($period->relativeTo($point)->notContain());
            $this->assertTrue($period->relativeTo($point)->atStart());
            $this->assertFalse($period->relativeTo($point)->notAtStart());
            $this->assertTrue($period->relativeTo($point)->atBound());
            $this->assertFalse($period->relativeTo($point)->notAtBound());
            $this->assertFalse($period->relativeTo($point)->atEnd());
            $this->assertTrue($period->relativeTo($point)->notAtEnd());
            $this->assertFalse($period->relativeTo($point)->isBetween());
            $this->assertTrue($period->relativeTo($point)->isNotBetween());
        }
    }

    public function testPositionsInside()
    {
        $month = Month::builder()->byIntParams(2021, 01);
        $period = Period::builder()->byMonth($month);

        $day = $month->days()->first()->next();

        $points = [
            $day,
            Time::builder()->forDay($day)->time(10, 0),
            Minute::builder()->midnightDay($day),
            Hour::builder()->midnightDay($day),
        ];

        foreach ($points as $point) {
            $this->assertFalse($period->relativeTo($point)->instantIsBefore());
            $this->assertTrue($period->relativeTo($point)->instantIsNotBefore());
            $this->assertFalse($period->relativeTo($point)->periodIsBefore());
            $this->assertTrue($period->relativeTo($point)->periodIsNotBefore());
            $this->assertFalse($period->relativeTo($point)->instantIsAfter());
            $this->assertTrue($period->relativeTo($point)->instantIsNotAfter());
            $this->assertFalse($period->relativeTo($point)->periodIsAfter());
            $this->assertTrue($period->relativeTo($point)->periodIsNotAfter());
            $this->assertTrue($period->relativeTo($point)->contain());
            $this->assertFalse($period->relativeTo($point)->notContain());
            $this->assertFalse($period->relativeTo($point)->atStart());
            $this->assertTrue($period->relativeTo($point)->notAtStart());
            $this->assertFalse($period->relativeTo($point)->atBound());
            $this->assertTrue($period->relativeTo($point)->notAtBound());
            $this->assertFalse($period->relativeTo($point)->atEnd());
            $this->assertTrue($period->relativeTo($point)->notAtEnd());
            $this->assertTrue($period->relativeTo($point)->isBetween());
            $this->assertFalse($period->relativeTo($point)->isNotBetween());
        }
    }

    public function testPositionsAtEnd()
    {
        $month = Month::builder()->byIntParams(2021, 01);
        $period = Period::builder()->byMonth($month);

        $day = $month->days()->last();

        $points = [
            $day,
            Time::builder()->endDay($day),
            Minute::builder()->endDay($day),
            Hour::builder()->endDay($day),
        ];

        foreach ($points as $point) {
            $this->assertFalse($period->relativeTo($point)->instantIsBefore());
            $this->assertTrue($period->relativeTo($point)->instantIsNotBefore());
            $this->assertFalse($period->relativeTo($point)->periodIsBefore());
            $this->assertTrue($period->relativeTo($point)->periodIsNotBefore());
            $this->assertFalse($period->relativeTo($point)->instantIsAfter());
            $this->assertTrue($period->relativeTo($point)->instantIsNotAfter());
            $this->assertFalse($period->relativeTo($point)->periodIsAfter());
            $this->assertTrue($period->relativeTo($point)->periodIsNotAfter());
            $this->assertTrue($period->relativeTo($point)->contain());
            $this->assertFalse($period->relativeTo($point)->notContain());
            $this->assertFalse($period->relativeTo($point)->atStart());
            $this->assertTrue($period->relativeTo($point)->notAtStart());
            $this->assertTrue($period->relativeTo($point)->atBound());
            $this->assertFalse($period->relativeTo($point)->notAtBound());
            $this->assertTrue($period->relativeTo($point)->atEnd());
            $this->assertFalse($period->relativeTo($point)->notAtEnd());
            $this->assertFalse($period->relativeTo($point)->isBetween());
            $this->assertTrue($period->relativeTo($point)->isNotBetween());
        }
    }

    public function testPositionsAfter()
    {
        $month = Month::builder()->byIntParams(2021, 01);
        $period = Period::builder()->byMonth($month);

        $day = $month->next()->days()->last();

        $points = [
            $day,
            Time::builder()->endDay($day),
            Minute::builder()->endDay($day),
            Hour::builder()->endDay($day),
        ];

        foreach ($points as $point) {
            $this->assertFalse($period->relativeTo($point)->instantIsBefore());
            $this->assertTrue($period->relativeTo($point)->instantIsNotBefore());
            $this->assertTrue($period->relativeTo($point)->periodIsBefore());
            $this->assertFalse($period->relativeTo($point)->periodIsNotBefore());
            $this->assertTrue($period->relativeTo($point)->instantIsAfter());
            $this->assertFalse($period->relativeTo($point)->instantIsNotAfter());
            $this->assertFalse($period->relativeTo($point)->periodIsAfter());
            $this->assertTrue($period->relativeTo($point)->periodIsNotAfter());
            $this->assertFalse($period->relativeTo($point)->contain());
            $this->assertTrue($period->relativeTo($point)->notContain());
            $this->assertFalse($period->relativeTo($point)->atStart());
            $this->assertTrue($period->relativeTo($point)->notAtStart());
            $this->assertFalse($period->relativeTo($point)->atBound());
            $this->assertTrue($period->relativeTo($point)->notAtBound());
            $this->assertFalse($period->relativeTo($point)->atEnd());
            $this->assertTrue($period->relativeTo($point)->notAtEnd());
            $this->assertFalse($period->relativeTo($point)->isBetween());
            $this->assertTrue($period->relativeTo($point)->isNotBetween());
        }
    }

    public function testIterator()
    {
        $currentMonth = Month::builder()->now();
        $period = Period::builder()->byMonth($currentMonth);

        $startPoint = $currentMonth->days()->first();

        $this->assertSame($currentMonth->days()->amount(), count($period->dayScale()->array()));

        foreach ($period->dayScale()->iterator() as $day) {
            $this->assertTrue($startPoint->compareTo($day)->isEqual());
            $startPoint = $startPoint->next();
        }
    }
}