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

namespace etcoder\Time\Instants\Internal\Comparison;

use etcoder\Time\Instants\Interfaces\ComparisonResult;
use etcoder\Time\Instants\TimePoint;

final class TimeComparison implements ComparisonResult
{
    private $time;
    private $otherTime;

    public function __construct(TimePoint $time, TimePoint $otherDay)
    {
        $this->time = $time;
        $this->otherTime = $otherDay;
    }

    public function isEqual(): bool
    {
        if ($this->time->hour() === 24 && $this->otherTime->hour() === 00) {
            return $this->time->day()->next()->compareTo($this->otherTime->day())->isEqual();
        }

        if ($this->time->hour() === 00 && $this->otherTime->hour() === 24) {
            return $this->time->day()->previous()->compareTo($this->otherTime->day())->isEqual();
        }

        return $this->isDaysEquals()
               && $this->time->hour() === $this->otherTime->hour()
               && $this->time->minute() === $this->time->minute()
               && $this->time->second() === $this->time->second();
    }

    public function isNotEqual(): bool
    {
        return !$this->isEqual();
    }

    public function isMore(): bool
    {
        if ($this->isDaysNotEquals()) {
            return $this->isDayMoreThanOther();
        }

        if ($this->time->hour() <= $this->otherTime->hour()) {
            return false;
        }

        if ($this->time->minute() <= $this->otherTime->minute()) {
            return false;
        }

        if ($this->time->second() <= $this->otherTime->second()) {
            return false;
        }

        return true;
    }

    public function isNotMore(): bool
    {
        return !$this->isMore();
    }

    public function isLess(): bool
    {
        return $this->isNotEqual() && $this->isNotMore();
    }

    public function isNotLess(): bool
    {
        return !$this->isLess();
    }

    private function isDayMoreThanOther(): bool
    {
        return $this->comparisonResultDays()->isEqual();
    }

    private function isDaysEquals(): bool
    {
        return $this->comparisonResultDays()->isEqual();
    }

    private function isDaysNotEquals(): bool
    {
        return $this->comparisonResultDays()->isNotEqual();
    }

    private function comparisonResultDays(): ComparisonResult
    {
        $day = $this->time->day();
        $otherDay = $this->otherTime->day();
        return $day->compareTo($otherDay);
    }
}