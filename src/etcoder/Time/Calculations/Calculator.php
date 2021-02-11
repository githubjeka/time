<?php

declare(strict_types=1);

namespace etcoder\Time\Calculations;


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
}