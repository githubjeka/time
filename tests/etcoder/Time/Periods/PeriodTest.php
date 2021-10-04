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

use etcoder\Time\Instants\Day;
use etcoder\Time\Instants\Month;
use etcoder\Time\Instants\Time;
use PHPUnit\Framework\TestCase;

use function etcoder\Time\Instants\Builders\firstDayOfMonth;
use function etcoder\Time\Instants\Builders\lastDayOfMonth;

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

        $this->assertTrue(firstDayOfMonth($currentMonth)->compareTo($period->dayScale()->start())->isEqual());
        $this->assertTrue(lastDayOfMonth($currentMonth)->compareTo($period->dayScale()->end())->isEqual());

        $period = new Period(Time::builder()->today(12, 10), Time::builder()->today(13, 15));

        $this->assertSame(12, $period->hourScale()->start()->value());
        $this->assertSame(13, $period->hourScale()->end()->value());
        $this->assertSame(10, $period->minuteScale()->start()->value());
        $this->assertSame(15, $period->minuteScale()->end()->value());
        $this->assertSame(0, $period->secondScale()->start()->second());
        $this->assertSame(0, $period->secondScale()->end()->second());

        $day = Day::builder()->byIntParams(2021,1,2);
        $period = Period::builder()->byDay($day);
        $this->assertSame(2021, $period->yearScale()->start()->number());
        $this->assertSame(1, $period->monthScale()->start()->number());
        $this->assertSame(2, $period->dayScale()->start()->number());
        $this->assertSame(2, $period->dayScale()->end()->number());
        $this->assertSame(0, $period->hourScale()->start()->value());
        $this->assertSame(0, $period->minuteScale()->start()->value());
        $this->assertSame(0, $period->secondScale()->start()->second());
        $this->assertSame(24, $period->hourScale()->end()->value());
        $this->assertSame(0, $period->minuteScale()->end()->value());
        $this->assertSame(0, $period->secondScale()->end()->second());
    }

    public function testIterator()
    {
        $currentMonth = Month::builder()->now();
        $period = Period::builder()->byMonth($currentMonth);

        $startPoint = firstDayOfMonth($currentMonth);

        $this->assertSame($currentMonth->numberOfDays(), count($period->dayScale()->array()));

        foreach ($period->dayScale()->iterator() as $day) {
            $this->assertTrue($startPoint->compareTo($day)->isEqual());
            $startPoint = $startPoint->next();
        }
    }
}