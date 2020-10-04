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
use etcoder\Time\Instants\Month;

final class MonthsComparison implements ComparisonResult
{
    private $month;
    private $otherMonth;

    public function __construct(Month $month, Month $otherMonth)
    {
        $this->month = $month;
        $this->otherMonth = $otherMonth;
    }

    public function isEqual(): bool
    {
        return $this->isYearsEquals() && $this->month->number() === $this->otherMonth->number();
    }

    public function isNotEqual(): bool
    {
        return !$this->isEqual();
    }

    public function isLess(): bool
    {
        if ($this->isYearsEquals()) {
            return $this->month->number() < $this->otherMonth->number();
        }

        return $this->isYearLessThanOtherYear();
    }

    public function isNotLess(): bool
    {
        return !$this->isLess();
    }

    public function isMore(): bool
    {
        return $this->isNotEqual() && $this->isNotLess();
    }

    public function isNotMore(): bool
    {
        return !$this->isMore();
    }

    private function isYearLessThanOtherYear(): bool
    {
        return $this->comparisonResultYears()->isLess();
    }

    private function isYearsEquals(): bool
    {
        return $this->comparisonResultYears()->isEqual();
    }

    private function comparisonResultYears(): ComparisonResult
    {
        $year = $this->month->year();
        $otherYear = $this->otherMonth->year();
        return $year->compareTo($otherYear);
    }

}