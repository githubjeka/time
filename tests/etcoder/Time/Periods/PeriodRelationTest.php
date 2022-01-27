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

class PeriodRelationTest extends TestCase
{
    public function testAfterBefore()
    {
        $currentMonth = Month::builder()->now();
        $prevMonth = $currentMonth->previous();
        $nextMonth = $currentMonth->next();
        $period = Period::builder()->byMonth($currentMonth);
        $previousPeriod = Period::builder()->byMonth($prevMonth);
        $nextPeriod = Period::builder()->byMonth($nextMonth);

        $this->assertTrue($period->positionTo($previousPeriod)->isAfter());
        $this->assertTrue($period->positionTo($nextPeriod)->isBefore());

        $this->assertFalse($period->positionTo($previousPeriod)->isBefore());
        $this->assertFalse($previousPeriod->positionTo($period)->isAfter());
        $this->assertFalse($period->positionTo($nextPeriod)->isAfter());
        $this->assertFalse($nextPeriod->positionTo($period)->isBefore());
    }

    public function testTouch()
    {
        $currentMonth = Month::builder()->now();
        $prevMonth = $currentMonth->previous();
        $nextMonth = $currentMonth->next();
        $period = Period::builder()->byMonth($currentMonth);
        $previousPeriod = Period::builder()->byMonth($prevMonth);
        $nextPeriod = Period::builder()->byMonth($nextMonth);

        $this->assertTrue($period->positionTo($previousPeriod)->endOfThePrevious());
        $this->assertFalse($period->positionTo($previousPeriod)->beginningOfTheNext());

        $this->assertFalse($period->positionTo($nextPeriod)->endOfThePrevious());
        $this->assertTrue($period->positionTo($nextPeriod)->beginningOfTheNext());
    }
}