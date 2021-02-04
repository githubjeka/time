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
use etcoder\Time\Instants\Time;

final class BuilderTime
{
    private $day;

    public function __construct()
    {
        $this->day = Day::builder()->now();
    }

    public function today(int $hour, int $minute, int $second = 0): Time
    {
        return $this->time($hour, $minute, $second);
    }

    public function forDay(Day $day): BuilderTime
    {
        $this->day = $day;
        return $this;
    }

    public function time(int $hour, int $minute, int $second = 0): Time
    {
        return new Time($this->day, $hour, $minute, $second);
    }

    public function midnightDay(Day $day): Time
    {
        return $this->forDay($day)->time(0, 0);
    }

    public function endDay(Day $day): Time
    {
        return $this->forDay($day)->time(24, 0);
    }
}