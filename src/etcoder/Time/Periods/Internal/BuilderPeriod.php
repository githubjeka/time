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


use etcoder\Time\Instants\Month;
use etcoder\Time\Instants\Time;
use etcoder\Time\Instants\Year;
use etcoder\Time\Periods\Period;
use etcoder\Time\Periods\Interfaces\BuilderPeriod as BuilderTimeInterface;

use function etcoder\Time\Instants\Builders\December;
use function etcoder\Time\Instants\Builders\January;

final class BuilderPeriod implements BuilderTimeInterface
{
    public function byYear(Year $year): Period
    {
        $startPoint = Time::builder()->midnightDay(January($year->number())->days()->first());
        $endPoint = Time::builder()->endDay(December($year->number())->days()->last());
        return new Period($startPoint, $endPoint);
    }

    public function currentMonth(): Period
    {
        $month = Month::builder()->now();
        return $this->byMonth($month);
    }

    public function byMonth(Month $month): Period
    {
        $startPoint = Time::builder()->midnightDay($month->days()->first());
        $endPoint = Time::builder()->endDay($month->days()->last());
        return new Period($startPoint, $endPoint);
    }

    public function currentYear(): Period
    {
        $year = Year::builder()->now();
        return $this->byYear($year);
    }
}