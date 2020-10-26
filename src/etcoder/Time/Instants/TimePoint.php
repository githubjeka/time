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

namespace etcoder\Time\Instants;


use etcoder\Time\Instants\Builders\BuilderTime;
use etcoder\Time\Instants\Interfaces\ComparisonResult;
use etcoder\Time\Instants\Internal\Comparison\TimeComparison;
use etcoder\Time\Instants\Internal\Instant;

class TimePoint extends Instant
{
    private $day;
    private $hour;
    private $minute;
    private $second;

    public function __construct(Day $day, int $hour, int $minute, int $second)
    {
        if ($hour > 24 || $hour < 0) {
            throw new \InvalidArgumentException();
        }

        if ($minute > 60 || $minute < 0) {
            throw new \InvalidArgumentException();
        }

        if ($second > 60 || $second < 0) {
            throw new \InvalidArgumentException();
        }

        if ($hour === 24 && $minute !== 0 && $second !== 0) {
            throw new \InvalidArgumentException();
        }

        $this->day = $day;
        $this->hour = $hour;
        $this->minute = $minute;
        $this->second = $second;
    }

    public static function builder(): BuilderTime
    {
        return new BuilderTime();
    }

    public function day(): Day
    {
        return $this->day;
    }

    public function hour(): int
    {
        return $this->hour;
    }

    public function minute(): int
    {
        return $this->minute;
    }

    public function second(): int
    {
        return $this->second;
    }

    public function next(int $step = 1)
    {
        $newTime = $this;
        while ($step > 0) {
            $newTime = $this->nextSecond($newTime);
            $step--;
        }
        return $newTime;
    }

    public function previous(int $step = 1)
    {
        $newTime = $this;
        while ($step > 0) {
            $newTime = $this->prevSecond($newTime);
            $step--;
        }
        return $newTime;
    }

    private function nextSecond(TimePoint $time): TimePoint
    {
        if ($time->hour === 24) {
            return new TimePoint($time->day->next(), 0, 0, 1);
        }

        if ($time->second !== 59) {
            return new TimePoint($time->day, $time->hour(), $time->minute(), $time->second() + 1);
        }

        if ($time->minute !== 59) {
            return new TimePoint($time->day, $time->hour(), $time->minute() + 1, 0);
        }

        if ($time->hour !== 23) {
            return new TimePoint($time->day, $time->hour() + 1, 0, 0);
        }

        return new TimePoint($time->day->next(), 0, 0, 1);
    }

    private function prevSecond(TimePoint $time): TimePoint
    {
        if ($time->second !== 00) {
            return new TimePoint($time->day, $time->hour(), $time->minute(), $time->second() - 1);
        }

        if ($time->minute !== 00) {
            return new TimePoint($time->day, $time->hour(), $time->minute() - 1, 59);
        }

        if ($time->hour !== 00) {
            return new TimePoint($time->day, $time->hour() - 1, 59, 59);
        }

        return new TimePoint($time->day->previous(), 23, 59, 59);
    }

    /**
     * @param Interfaces\Instant|TimePoint $instant
     * @return ComparisonResult
     */
    protected function comparisonResult(Interfaces\Instant $instant): ComparisonResult
    {
        return new TimeComparison($this, $instant);
    }
}