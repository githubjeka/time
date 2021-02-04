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


use etcoder\Time\Instants\Builders\BuilderMinute;
use etcoder\Time\Instants\Interfaces\ComparisonResult;
use etcoder\Time\Instants\Internal\Comparison\MinutesComparison;
use etcoder\Time\Instants\Internal\Instant;

final class Minute extends Instant
{
    private $day;
    private $hour;
    private $minute;

    public function __construct(Day $day, int $hour, int $minute)
    {
        if ($hour > 24 || $hour < 0) {
            throw new \InvalidArgumentException();
        }

        if ($minute > 60 || $minute < 0) {
            throw new \InvalidArgumentException();
        }

        if ($hour === 24 && $minute !== 0) {
            throw new \InvalidArgumentException();
        }

        $this->day = $day;
        $this->hour = $hour;
        $this->minute = $minute;
    }

    public static function builder(): BuilderMinute
    {
        return new BuilderMinute();
    }

    public function day(): Day
    {
        return $this->day;
    }

    public function hour(): int
    {
        return $this->hour;
    }

    public function value(): int
    {
        return $this->minute;
    }

    public function next(int $step = 1): Minute
    {
        $newTime = $this;
        while ($step > 0) {
            $newTime = $this->nextMinute($newTime);
            $step--;
        }
        return $newTime;
    }

    public function previous(int $step = 1): Minute
    {
        $newTime = $this;
        while ($step > 0) {
            $newTime = $this->prevMinute($newTime);
            $step--;
        }
        return $newTime;
    }

    /**
     * @param Interfaces\Instant|Minute $instant
     * @return ComparisonResult
     */
    protected function comparisonResult(Interfaces\Instant $instant): ComparisonResult
    {
        return new MinutesComparison($this, $instant);
    }

    private function nextMinute(Minute $time): Minute
    {
        if ($time->hour === 24) {
            return new Minute($time->day->next(), 0, 1);
        }

        if ($time->minute !== 59) {
            return new Minute($time->day, $time->hour(), $time->value() + 1);
        }

        if ($time->hour !== 23) {
            return new Minute($time->day, $time->hour() + 1, 0);
        }

        return new Minute($time->day->next(), 0, 0);
    }

    private function prevMinute(Minute $time): Minute
    {
        if ($time->minute !== 00) {
            return new Minute($time->day, $time->hour(), $time->value() - 1);
        }

        if ($time->hour !== 00) {
            return new Minute($time->day, $time->hour() - 1, 59);
        }

        return new Minute($time->day->previous(), 23, 59);
    }
}