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

use function etcoder\Time\Instants\Builders\firstDayOfMonth;
use function etcoder\Time\Instants\Builders\lastDayOfMonth;

class PeriodInstantPositionTest extends TestCase
{
    public function testPositionsBefore()
    {
        $month = Month::builder()->byIntParams(2021, 01);
        $period = Period::builder()->byMonth($month);

        $day = firstDayOfMonth($month->previous());

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

        $day = firstDayOfMonth($month);

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

        $day = firstDayOfMonth($month)->next();

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

        $day = lastDayOfMonth($month);

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

        $day = lastDayOfMonth($month->next());

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
}