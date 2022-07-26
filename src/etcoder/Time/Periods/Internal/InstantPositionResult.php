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

use etcoder\Time\Instants\Day;
use etcoder\Time\Instants\Hour;
use etcoder\Time\Instants\Internal\Instant;
use etcoder\Time\Instants\Minute;
use etcoder\Time\Instants\Month;
use etcoder\Time\Instants\Time;
use etcoder\Time\Instants\Year;
use etcoder\Time\Periods\Period;

/**
 * Total results of position for Instant and Period
 */
final class InstantPositionResult
{
    /** @var Instant */
    private $start;
    /** @var Instant */
    private $end;
    /** @var Instant */
    private $point;

    public function __construct(Period $period, Instant $instant)
    {
        $this->point = $instant;

        $class = get_class($instant);
        switch ($class) {
            case Year::class :
                $this->start = $period->yearScale()->start();
                $this->end = $period->yearScale()->end();
                break;
            case Month::class :
                $this->start = $period->monthScale()->start();
                $this->end = $period->monthScale()->end();
                break;
            case Day::class:
                $this->start = $period->dayScale()->start();
                $this->end = $period->dayScale()->end();
                break;
            case Minute::class :
                $this->start = $period->minuteScale()->start();
                $this->end = $period->minuteScale()->end();
                break;
            case Hour::class :
                $this->start = $period->hourScale()->start();
                $this->end = $period->hourScale()->end();
                break;
            case Time::class:
                $this->start = $period->secondsScale()->start();
                $this->end = $period->secondsScale()->end();
                break;
            default:
                throw new \LogicException('Instant cannot be processed');
        }
    }

    public function instantIsBefore(): bool
    {
        return $this->point->compareTo($this->start)->isLess();
    }

    public function instantIsNotBefore(): bool
    {
        return $this->instantIsBefore() === false;
    }

    public function periodIsBefore(): bool
    {
        return $this->end->compareTo($this->point)->isLess();
    }

    public function periodIsNotBefore(): bool
    {
        return $this->periodIsBefore() === false;
    }

    public function instantIsAfter(): bool
    {
        return $this->point->compareTo($this->end)->isMore();
    }

    public function instantIsNotAfter(): bool
    {
        return $this->instantIsAfter() === false;
    }

    public function periodIsAfter(): bool
    {
        return $this->start->compareTo($this->point)->isMore();
    }

    public function periodIsNotAfter(): bool
    {
        return $this->periodIsAfter() === false;
    }

    public function atStart(): bool
    {
        return $this->start->compareTo($this->point)->isEqual();
    }

    public function notAtStart(): bool
    {
        return $this->start->compareTo($this->point)->isNotEqual();
    }

    public function atEnd(): bool
    {
        return $this->end->compareTo($this->point)->isEqual();
    }

    public function notAtEnd(): bool
    {
        return $this->end->compareTo($this->point)->isNotEqual();
    }

    public function atBound(): bool
    {
        return $this->atStart() || $this->atEnd();
    }

    public function notAtBound(): bool
    {
        return $this->notAtStart() && $this->notAtEnd();
    }

    public function isBetween(): bool
    {
        return $this->start->compareTo($this->point)->isLess() &&
               $this->end->compareTo($this->point)->isMore();
    }

    public function isNotBetween(): bool
    {
        return $this->isBetween() === false;
    }

    public function contain(): bool
    {
        return $this->isBetween() || $this->atBound();
    }

    public function notContain(): bool
    {
        return $this->contain() === false;
    }
}