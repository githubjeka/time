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
use etcoder\Time\Instants\Year;

final class YearsComparison implements ComparisonResult
{
    private $year;
    private $otherYear;

    public function __construct(Year $year, Year $otherYear)
    {
        $this->year = $year;
        $this->otherYear = $otherYear;
    }

    public function isEqual(): bool
    {
        return $this->year->number() === $this->otherYear->number();
    }

    public function isLess(): bool
    {
        return $this->year->number() < $this->otherYear->number();
    }

    public function isMore(): bool
    {
        return $this->year->number() > $this->otherYear->number();
    }

    public function isNotEqual(): bool
    {
        return !$this->isEqual();
    }

    public function isNotLess(): bool
    {
        return !$this->isLess();
    }

    public function isNotMore(): bool
    {
        return !$this->isMore();
    }
}