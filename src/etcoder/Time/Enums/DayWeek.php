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

class DayWeek
{
    public const SUNDAY = 'SUNDAY';
    public const MONDAY = 'MONDAY';
    public const TUESDAY = 'TUESDAY';
    public const WEDNESDAY = 'WEDNESDAY';
    public const THURSDAY = 'THURSDAY';
    public const FRIDAY = 'FRIDAY';
    public const SATURDAY = 'SATURDAY';

    public static function fromDate(DateTimeInterface $dateTime): string
    {
        switch ((int)$dateTime->format('w')) {
            case 0:
                return DayWeek::SUNDAY;
            case  1 :
                return DayWeek::MONDAY;
            case   2 :
                return DayWeek::TUESDAY;
            case    3 :
                return DayWeek::WEDNESDAY;
            case     4 :
                return DayWeek::THURSDAY;
            case    5 :
                return DayWeek::FRIDAY;
            case      6 :
                return DayWeek::SATURDAY;
        }
    }
}