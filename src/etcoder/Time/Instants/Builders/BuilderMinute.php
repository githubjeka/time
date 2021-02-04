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
use etcoder\Time\Instants\Minute;

final class BuilderMinute
{
    public function today(int $hour, int $minute): Minute
    {
        return new Minute(Day::builder()->now(), $hour, $minute);
    }

    public function midnightDay(Day $day): Minute
    {
        return new Minute($day, 0, 0);
    }

    public function endDay(Day $day): Minute
    {
        return new Minute($day, 24, 0);
    }
}