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
use etcoder\Time\Instants\Hour;

final class BuilderHour
{
    public function hourOfDay(Day $day, int $hour): Hour
    {
        return new Hour($day, $hour);
    }

    public function today(int $hour): Hour
    {
        return new Hour(Day::builder()->now(), $hour);
    }

    public function midnightDay(Day $day): Hour
    {
        return new Hour($day, 0);
    }

    public function endDay(Day $day): Hour
    {
        return new Hour($day, 24);
    }
}