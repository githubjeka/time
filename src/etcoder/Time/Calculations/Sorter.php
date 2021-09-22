<?php

declare(strict_types=1);

namespace etcoder\Time\Calculations;


use etcoder\Time\Periods\Period;
use etcoder\Time\Periods\Periods;

class Sorter
{
    public function sortPeriods(Periods $periods, int $sort = SORT_ASC): Periods
    {
        $this->checkSortParam($sort);

        $periodsArray = $periods->toArray();
        usort(
            $periodsArray,
            function (Period $onePeriod, Period $anotherPeriod) {
                $startAnotherPeriod = $anotherPeriod->secondScale()->start();
                $position = $onePeriod->relativeTo($startAnotherPeriod);

                if ($position->atStart()) {
                    return 0;
                }

                if ($position->instantIsBefore()) {
                    return -1;
                }

                return 1;
            }
        );

        if ($sort === SORT_ASC) {
            $result = array_reverse($periodsArray);
        } else {
            $result = $periodsArray;
        }

        return new Periods(...$result);
    }

    private function checkSortParam(int $sort): void
    {
        if ($sort !== SORT_ASC && $sort !== SORT_DESC) {
            throw new \InvalidArgumentException("sort params is wrong $sort");
        }
    }
}