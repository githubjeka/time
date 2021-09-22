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

use etcoder\Time\Calculations\Sorter;
use etcoder\Time\Instants\Month;
use PHPUnit\Framework\TestCase;


class PeriodsSortTest extends TestCase
{
    public function testSortAsc()
    {
        $currentMonth = Month::builder()->now();
        $prevMonth = $currentMonth->previous();
        $prevPrevMonth = $prevMonth->previous();
        $onePeriod = Period::builder()->byMonth($currentMonth);
        $secondPeriod = Period::builder()->byMonth($prevMonth);
        $thirdPeriod = Period::builder()->byMonth($prevPrevMonth);
        $periods = new Periods($onePeriod, $secondPeriod, $thirdPeriod);

        $sort = new Sorter();
        $sortedPeriods = $sort->sortPeriods($periods, SORT_ASC);

        $this->assertEquals($prevPrevMonth->number() , $sortedPeriods->offsetGet(0)->monthScale()->start()->number());
        $this->assertEquals($prevMonth->number() , $sortedPeriods->offsetGet(1)->monthScale()->start()->number());
        $this->assertEquals($currentMonth->number() , $sortedPeriods->offsetGet(2)->monthScale()->start()->number());
    }

    public function testSortDesc()
    {
        $currentMonth = Month::builder()->now();
        $prevMonth = $currentMonth->previous();
        $prevPrevMonth = $prevMonth->previous();
        $onePeriod = Period::builder()->byMonth($currentMonth);
        $secondPeriod = Period::builder()->byMonth($prevMonth);
        $thirdPeriod = Period::builder()->byMonth($prevPrevMonth);

        $sort = new Sorter();

        $periods = new Periods($onePeriod, $secondPeriod, $thirdPeriod);
        $sortedPeriods = $sort->sortPeriods($periods, SORT_DESC);
        $this->assertEquals($currentMonth->number() , $sortedPeriods->offsetGet(0)->monthScale()->start()->number());
        $this->assertEquals($prevMonth->number() , $sortedPeriods->offsetGet(1)->monthScale()->start()->number());
        $this->assertEquals($prevPrevMonth->number() , $sortedPeriods->offsetGet(2)->monthScale()->start()->number());

        $newPeriods = new Periods($secondPeriod, $onePeriod, $thirdPeriod);
        $sortedPeriods = $sort->sortPeriods($newPeriods, SORT_DESC);

        $this->assertEquals($currentMonth->number() , $sortedPeriods->offsetGet(0)->monthScale()->start()->number());
        $this->assertEquals($prevMonth->number() , $sortedPeriods->offsetGet(1)->monthScale()->start()->number());
        $this->assertEquals($prevPrevMonth->number() , $sortedPeriods->offsetGet(2)->monthScale()->start()->number());
    }
}