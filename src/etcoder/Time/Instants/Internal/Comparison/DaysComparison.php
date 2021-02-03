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

use etcoder\Time\Instants\Day;
use etcoder\Time\Instants\Interfaces\ComparisonResult;

final class DaysComparison implements ComparisonResult
{
    private $day;
    private $otherDay;

    public function __construct(Day $day, Day $otherDay)
    {
        $this->day = $day;
        $this->otherDay = $otherDay;
    }

    public function isEqual(): bool
    {
        return $this->isMonthsEquals() && $this->day->number() === $this->otherDay->number();
    }

    public function isNotEqual(): bool
    {
        return !$this->isEqual();
    }

    public function isMore(): bool
    {
        if ($this->isMonthsEquals()) {
            return $this->day->number() > $this->otherDay->number();
        }

        return $this->isMonthMoreThanOther();
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

    private function isMonthMoreThanOther(): bool
    {
        return $this->comparisonResultMonths()->isMore();
    }

    private function isMonthsEquals(): bool
    {
        return $this->comparisonResultMonths()->isEqual();
    }

    private function comparisonResultMonths(): ComparisonResult
    {
        $month = $this->day->month();
        $otherMonth = $this->otherDay->month();
        return $month->compareTo($otherMonth);
    }
}