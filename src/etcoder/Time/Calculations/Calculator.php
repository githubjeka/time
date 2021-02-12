<?php

declare(strict_types=1);

namespace etcoder\Time\Calculations;


use etcoder\Time\Instants\Internal\Instant;
use etcoder\Time\Instants\Time;
use etcoder\Time\Periods\Duration;
use etcoder\Time\Periods\Period;
use etcoder\Time\Periods\Periods;

class Calculator
{
    public function split(Period $period, Instant ...$instants): Periods
    {
        $result = [];

        usort(
            $instants,
            function (Instant $a, Instant $b) {
                if ($a->compareTo($b)->isEqual()) {
                    return 0;
                }

                if ($a->compareTo($b)->isLess()) {
                    return -1;
                }
                return 1;
            }
        );

        $start = $period->secondScale()->start();

        foreach ($instants as $instant) {
            if ($period->relativeTo($instant)->isBetween()) {
                $result[] = new Period($start, $instant);
                $start = $instant;
            }
        }

        if (count($result) === 0) {
            return new Periods($period);
        } else {
            $result[] = new Period(
                $start,
                $period->secondScale()->end()
            );
        }

        return new Periods(...$result);
    }

    public function duration(Time $point, Time $otherPoint): Duration
    {
        $years = (int)abs($point->day()->year()->number() - $otherPoint->day()->year()->number());
        $months = (int)abs($point->day()->month()->number() - $otherPoint->day()->month()->number());
        $days = (int)abs($point->day()->number() - $otherPoint->day()->number());
        $hours = (int)abs($point->hour() - $otherPoint->hour());
        $minutes = (int)abs($point->minute() - $otherPoint->minute());
        $seconds = (int)abs($point->second() - $otherPoint->second());
    }
}