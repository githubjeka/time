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
use etcoder\Time\Instants\TimePoint;
use PHPUnit\Framework\TestCase;

class TimePeriodTest extends TestCase
{
    public function testBuilder()
    {
        $currentMonth = Month::builder()->now();
        $period = TimePeriod::builder()->month($currentMonth);

        $this->assertInstanceOf(TimePoint::class, $period->startInstant());
        $this->assertInstanceOf(TimePoint::class, $period->endInstant());

        $this->assertTrue($currentMonth->compareTo($period->startInstant()->day()->month())->isEqual());
        $this->assertTrue($currentMonth->compareTo($period->endInstant()->day()->month())->isEqual());

        $this->assertTrue($currentMonth->days()->first()->compareTo($period->startInstant()->day())->isEqual());
        $this->assertTrue($currentMonth->days()->last()->compareTo($period->endInstant()->day())->isEqual());
    }

    public function testIterator()
    {
        $currentMonth = Month::builder()->now();
        $period = TimePeriod::builder()->month($currentMonth);

        $startPoint = $period->startInstant();
        $limit = 10;
        foreach ($period->iterator() as $timePoint) {
            $this->assertTrue($startPoint->compareTo($timePoint)->isEqual());
            $startPoint = $startPoint->next();
            $limit--;
            if ($limit === 0) {
                break;
            }
        }
    }
}