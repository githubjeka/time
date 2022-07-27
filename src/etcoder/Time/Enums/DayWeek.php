<?php

/**
 * This file is part of the etcoder/Time package.
 *
 * Evgeniy Tkachenko <et.coder@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace etcoder\Time\Enums;

use DateTimeInterface;

enum DayWeek
{
    case SUNDAY;
    case MONDAY;
    case TUESDAY;
    case WEDNESDAY;
    case THURSDAY;
    case FRIDAY;
    case SATURDAY;

    public static function fromDate(DateTimeInterface $dateTime): DayWeek
    {
        return match ((int)$dateTime->format('w')) {
            0 => DayWeek::SUNDAY,
            1 => DayWeek::MONDAY,
            2 => DayWeek::TUESDAY,
            3 => DayWeek::WEDNESDAY,
            4 => DayWeek::THURSDAY,
            5 => DayWeek::FRIDAY,
            6 => DayWeek::SATURDAY,
        };
    }
}