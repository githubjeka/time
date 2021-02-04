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
use etcoder\Time\Instants\Hour;
use etcoder\Time\Instants\Time;

final class HoursComparison implements ComparisonResult
{
    private $timeComparison;

    public function __construct(Hour $hour, Hour $otherHour)
    {
        $this->timeComparison = new TimeComparison(
            new Time($hour->day(), $hour->value(), 0, 0),
            new Time($otherHour->day(), $otherHour->value(), 0, 0)
        );
    }

    public function isEqual(): bool
    {
       return $this->timeComparison->isEqual();
    }

    public function isNotEqual(): bool
    {
        return $this->timeComparison->isNotEqual();
    }

    public function isMore(): bool
    { 
        return $this->timeComparison->isMore();
    }

    public function isNotMore(): bool
    {
        return $this->timeComparison->isNotMore();
    }

    public function isLess(): bool
    {
        return $this->timeComparison->isLess();
    }

    public function isNotLess(): bool
    {
        return $this->timeComparison->isNotLess();
    }
}