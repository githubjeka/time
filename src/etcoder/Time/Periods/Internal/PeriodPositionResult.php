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

namespace etcoder\Time\Periods\Internal;

use etcoder\Time\Instants\Internal\Instant;
use etcoder\Time\Periods\Period;

/**
 * Total results of position for two period
 */
final class PeriodPositionResult
{
    /**
     * @var \etcoder\Time\Instants\Time
     */
    private $startFirstPeriod, $endFirstPeriod, $startSecondPeriod, $endSecondPeriod;

    public function __construct(Period $period, Period $anotherPeriod)
    {
        $this->startFirstPeriod = $period->secondsScale()->start();
        $this->endFirstPeriod = $period->secondsScale()->end();

        $this->startSecondPeriod = $anotherPeriod->secondsScale()->start();
        $this->endSecondPeriod = $anotherPeriod->secondsScale()->end();
    }

    public function isAfter(): bool
    {
        return $this->startFirstPeriod->compareTo($this->endSecondPeriod)->isNotLess();
    }

    public function isBefore(): bool
    {
        return $this->endFirstPeriod->compareTo($this->startSecondPeriod)->isNotMore();
    }

    public function beginningOfTheNext(): bool
    {
        return $this->endFirstPeriod->compareTo($this->startSecondPeriod)->isEqual();
    }

    public function endOfThePrevious(): bool
    {
        return $this->startFirstPeriod->compareTo($this->endSecondPeriod)->isEqual();
    }
}