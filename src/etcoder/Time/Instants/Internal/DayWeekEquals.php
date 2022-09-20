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

namespace etcoder\Time\Instants\Internal;

use etcoder\Time\Enums\DayWeek;

trait DayWeekEquals
{
    abstract public function name(): string;

    public function isSunday(): bool
    {
        return $this->name() === DayWeek::SUNDAY;
    }

    public function isMonday(): bool
    {
        return $this->name() === DayWeek::MONDAY;
    }

    public function isTuesday(): bool
    {
        return $this->name() === DayWeek::TUESDAY;
    }

    public function isWednesday(): bool
    {
        return $this->name() === DayWeek::WEDNESDAY;
    }

    public function isThursday(): bool
    {
        return $this->name() === DayWeek::THURSDAY;
    }

    public function isFriday(): bool
    {
        return $this->name() === DayWeek::FRIDAY;
    }

    public function isSaturday(): bool
    {
        return $this->name() === DayWeek::SATURDAY;
    }
}