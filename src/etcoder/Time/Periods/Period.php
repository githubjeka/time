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

namespace etcoder\Time\Periods;


use etcoder\Time\Calculations\Calculator;
use etcoder\Time\Calculations\results\Overlap;
use etcoder\Time\Calculations\results\Subtract;
use etcoder\Time\Instants\{Hour, Internal\Instant, Minute, Time};
use etcoder\Time\Periods\Internal\InstantPositionResult;
use etcoder\Time\Periods\Ranges\{DaysRange, HoursRange, MinutesRange, MonthRange, SecondsRange, YearsRange};

/**
 * Describes period of time.
 */
final class Period
{
    protected Time $startPoint;
    protected Time $endPoint;

    public function __construct(Time $start, Time $end)
    {
        if ($start->compareTo($end)->isMore()) {
            $this->startPoint = $end;
            $this->endPoint = $start;
        } else {
            $this->startPoint = $start;
            $this->endPoint = $end;
        }
    }

    public static function builder(): Internal\BuilderPeriod
    {
        return new Internal\BuilderPeriod();
    }

    public function yearScale(): YearsRange
    {
        return new YearsRange($this->startPoint->day()->month()->year(), $this->endPoint->day()->month()->year());
    }

    public function monthScale(): MonthRange
    {
        return new MonthRange($this->startPoint->day()->month(), $this->endPoint->day()->month());
    }

    public function dayScale(): DaysRange
    {
        return new DaysRange($this->startPoint->day(), $this->endPoint->day());
    }

    public function hourScale(): HoursRange
    {
        $start = new Hour($this->startPoint->day(), $this->startPoint->hour());
        $end = new Hour($this->endPoint->day(), $this->endPoint->hour());
        return new HoursRange($start, $end);
    }

    public function minuteScale(): MinutesRange
    {
        $start = new Minute($this->startPoint->day(), $this->startPoint->hour(), $this->startPoint->minute());
        $end = new Minute($this->endPoint->day(), $this->endPoint->hour(), $this->endPoint->minute());
        return new MinutesRange($start, $end);
    }

    public function secondScale(): SecondsRange
    {
        return new SecondsRange($this->startPoint, $this->endPoint);
    }

    public function inRelationTo(Instant $instant): InstantPositionResult
    {
        return new InstantPositionResult($this, $instant);
    }

    /**
     * @deprecated
     */
    public function relativeTo(Instant $instant): InstantPositionResult
    {
        return $this->inRelationTo($instant);
    }

    public function overlap(Period $period): Overlap
    {
        $calculator = new Calculator();
        return $calculator->overlap($this, $period);
    }

    public function subtract(Period $period): Subtract
    {
        $calculator = new Calculator();
        return $calculator->subtract($this, $period);
    }
}