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

namespace etcoder\Time\Periods\Internal;


use etcoder\Time\Instants\Day;
use etcoder\Time\Instants\Month;
use etcoder\Time\Instants\Time;
use etcoder\Time\Instants\Year;
use etcoder\Time\Periods\Period;

use function etcoder\Time\Instants\Builders\December;
use function etcoder\Time\Instants\Builders\firstDayOfMonth;
use function etcoder\Time\Instants\Builders\January;
use function etcoder\Time\Instants\Builders\lastDayOfMonth;

final class BuilderPeriod
{
    public function byYear(Year $year): Period
    {
        $startPoint = Time::builder()->midnightDay(firstDayOfMonth(January($year->number())));
        $endPoint = Time::builder()->endDay(lastDayOfMonth(December($year->number())));
        return new Period($startPoint, $endPoint);
    }

    public function currentMonth(): Period
    {
        $month = Month::builder()->now();
        return $this->byMonth($month);
    }

    public function byMonth(Month $month): Period
    {
        $startPoint = Time::builder()->midnightDay(firstDayOfMonth($month));
        $endPoint = Time::builder()->endDay(lastDayOfMonth($month));
        return new Period($startPoint, $endPoint);
    }

    public function currentYear(): Period
    {
        $year = Year::builder()->now();
        return $this->byYear($year);
    }

    public function byDay(Day $day): Period
    {
        return new Period(
            Time::builder()->midnightDay($day),
            Time::builder()->endDay($day)
        );
    }
}