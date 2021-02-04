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


use etcoder\Time\Instants\Builders\BuilderHour;
use etcoder\Time\Instants\Interfaces\ComparisonResult;
use etcoder\Time\Instants\Internal\Comparison\HoursComparison;
use etcoder\Time\Instants\Internal\Instant;

final class Hour extends Instant
{
    private $day;
    private $hour;

    public function __construct(Day $day, int $hour)
    {
        if ($hour > 24 || $hour < 0) {
            throw new \InvalidArgumentException();
        }

        $this->day = $day;
        $this->hour = $hour;
    }

    public static function builder(): BuilderHour
    {
        return new BuilderHour();
    }

    public function day(): Day
    {
        return $this->day;
    }

    public function value(): int
    {
        return $this->hour;
    }

    public function next(int $step = 1): Hour
    {
        $newTime = $this;
        while ($step > 0) {
            $newTime = $this->nextHour($newTime);
            $step--;
        }
        return $newTime;
    }

    public function previous(int $step = 1): Hour
    {
        $newTime = $this;
        while ($step > 0) {
            $newTime = $this->prevHour($newTime);
            $step--;
        }
        return $newTime;
    }

    /**
     * @param Interfaces\Instant|Hour $instant
     * @return ComparisonResult
     */
    protected function comparisonResult(Interfaces\Instant $instant): ComparisonResult
    {
        return new HoursComparison($this, $instant);
    }

    private function nextHour(Hour $time): Hour
    {
        if ($time->hour === 24) {
            return new Hour($time->day->next(), 0);
        }

        if ($time->hour !== 23) {
            return new Hour($time->day, $time->value() + 1);
        }

        return new Hour($time->day->next(), 0);
    }

    private function prevHour(Hour $time): Hour
    {
        if ($time->hour !== 00) {
            return new Hour($time->day, $time->value() - 1);
        }

        return new Hour($time->day->previous(), 23);
    }
}