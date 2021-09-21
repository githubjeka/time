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

use etcoder\Time\Instants\Month;
use PHPUnit\Framework\TestCase;

class PeriodsTest extends TestCase
{
    public function testBuilder()
    {
        $currentMonth = Month::builder()->now();
        $prevMonth = $currentMonth->previous();
        $prevPrevMonth = $prevMonth->previous();

        $onePeriod = Period::builder()->byMonth($currentMonth);
        $secondPeriod = Period::builder()->byMonth($prevMonth);
        $thirdPeriod = Period::builder()->byMonth($prevPrevMonth);

        $periods = new Periods($onePeriod, $secondPeriod, $thirdPeriod);
        $arrayPeriods = $periods->toArray();

        $this->assertInstanceOf(Periods::class, $periods);
        $this->assertTrue(3 === $periods->count());

        $this->assertIsArray($arrayPeriods);
        $this->assertEquals($onePeriod, $arrayPeriods[0]);
        $this->assertEquals($secondPeriod, $arrayPeriods[1]);
        $this->assertEquals($thirdPeriod, $arrayPeriods[2]);
    }
}