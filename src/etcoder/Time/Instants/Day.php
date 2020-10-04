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

use etcoder\Time\Instants\Builders\BuilderDay;
use etcoder\Time\Instants\Formats\DayFormatting;
use etcoder\Time\Instants\Interfaces\ComparisonResult;
use etcoder\Time\Instants\Internal\Comparison\DaysComparison;
use etcoder\Time\Instants\Internal\Instant;
use etcoder\Time\Instants\Internal\SeasonalMonth;

/**
 * @method Day[] arrayTo(Day $day, int $step = 1)
 * @method \Generator|Day[] iteratorTo(Day $day, int $step = 1)
 * @method ComparisonResult compareTo(Day $day)
 */
final class Day extends Instant
{
    use SeasonalMonth;

    private $month;
    private $numberDay;

    public function __construct(Month $month, int $numberDay)
    {
        if ($numberDay < 0) {
            throw new \InvalidArgumentException("Day of the month ($numberDay)cannot be negative");
        }

        $lastDay = $month->days()->lastNumber();
        if ($numberDay > $lastDay) {
            throw new \InvalidArgumentException("Day of the month cannot be more $lastDay");
        }

        $this->month = $month;
        $this->numberDay = $numberDay;
    }

    public static function builder(): BuilderDay
    {
        return new BuilderDay();
    }

    public function number(): int
    {
        return $this->numberDay;
    }

    public function year(): Year
    {
        return $this->month->year();
    }

    public function month(): Month
    {
        return $this->month;
    }

    public function format(): DayFormatting
    {
        return new DayFormatting($this);
    }

    public function isNotFirstDayMonth(): bool
    {
        return !$this->isFirstDayMonth();
    }

    public function isFirstDayMonth(): bool
    {
        $firstDay = $this->month()->days()->first();
        return $firstDay->compareTo($this)->isEqual();
    }

    public function isNotLastDayMonth(): bool
    {
        return !$this->isLastDayMonth();
    }

    public function isLastDayMonth(): bool
    {
        $lastDay = $this->month()->days()->last();
        return $lastDay->compareTo($this)->isEqual();
    }

    public function next(int $step = 1): Day
    {
        $newDay = $this;
        while ($step > 0) {
            $newDay = $this->nextOneForDay($newDay);
            $step--;
        }
        return $newDay;
    }

    public function previous(int $step = 1): Day
    {
        $newDay = $this;
        while ($step > 0) {
            $newDay = $this->prevOneForDay($newDay);
            $step--;
        }
        return $newDay;
    }

    /**
     * @param Interfaces\Instant|Day $instant
     * @return ComparisonResult
     */
    protected function comparisonResult(Interfaces\Instant $instant): ComparisonResult
    {
        return new DaysComparison($this, $instant);
    }

    protected function getMonth(): Month
    {
        return $this->month;
    }

    private function nextOneForDay(Day $day): Day
    {
        if ($day->isLastDayMonth()) {
            return $day->month->next()->days()->first();
        }

        return new Day($day->month, $day->numberDay + 1);
    }

    private function prevOneForDay(Day $day): Day
    {
        if ($day->isFirstDayMonth()) {
            return $day->month->previous()->days()->last();
        }

        return new Day($day->month, $day->numberDay - 1);
    }
}