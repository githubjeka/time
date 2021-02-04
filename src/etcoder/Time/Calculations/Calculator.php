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

        foreach ($instants as $instant) {
            if ($period->relativeTo($instant)->isBetween()) {
                $result[] = new Period(
                    $period->secondScale()->start(),
                    $instant
                );
                $result[] = new Period(
                    $instant,
                    $period->secondScale()->end()
                );
            }
        }

        if (count($result) === 0) {
            return new Periods($period);
        }

        return new Periods(...$result);
    }
}