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

namespace etcoder\Time\Instants\Builders;

use etcoder\Time\Instants\Day;
use etcoder\Time\Instants\TimePoint;

final class BuilderTime
{
    public function todayByMinute(int $hours, int $minutes): TimePoint
    {
        return new TimePoint(Day::builder()->now(), $hours, $minutes, 0);
    }

    public function midnightDay(Day $day): TimePoint
    {
        return new TimePoint($day, 0, 0, 0);
    }

    public function endDay(Day $day): TimePoint
    {
        return new TimePoint($day, 24, 0, 0);
    }
}