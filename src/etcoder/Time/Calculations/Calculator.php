<?php

declare(strict_types=1);

namespace etcoder\Time\Calculations;


use etcoder\Time\Calculations\results\Overlap;
use etcoder\Time\Instants\Internal\Instant;
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

    public function overlap(Period $period, Period $anotherPeriod): Overlap
    {
        $periods = new Periods($period, $anotherPeriod);

        $sorter = new Sorter();
        [$firstPeriod, $secondPeriod] = $sorter->sortPeriods($periods)->toArray();

        $firstStart = $firstPeriod->secondScale()->start();
        $firstFinish = $firstPeriod->secondScale()->end();

        $secondStart = $secondPeriod->secondScale()->start();
        $secondFinish = $secondPeriod->secondScale()->end();

        if ($firstStart->compareTo($secondFinish)->isLess() && $firstFinish->compareTo($secondStart)->isLess()) {
            return Overlap::null();
        }

        if ($firstFinish->compareTo($secondStart)->isEqual()) {
            return Overlap::null();
        }

        if ($firstStart->compareTo($secondStart)->isLess()) {
            $startTime = $secondStart;
        } else {
            $startTime = $firstStart;
        }

        if ($firstFinish->compareTo($secondFinish)->isLess()) {
            $finishTime = $firstFinish;
        } else {
            $finishTime = $secondFinish;
        }

        return new Overlap(new Period($startTime, $finishTime));
    }

    /**
     * @deprecated
     */
    public function intersection(Period $period, Period $anotherPeriod): Periods
    {
        $overlap = $this->overlap($period, $anotherPeriod);
        if ($overlap->withoutOverlap()) {
            return new Periods();
        }
        return new Periods($overlap->value());
    }
}