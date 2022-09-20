<?php

declare(strict_types=1);

namespace etcoder\Time\Calculations;


use etcoder\Time\Instants\Interfaces\HasInstant;
use etcoder\Time\Instants\Internal\Instant;
use etcoder\Time\Periods\Period;
use etcoder\Time\Periods\Periods;

class Sorter
{
    /**
     * @param  HasInstant[]|Instant[]  $objects
     * @param  bool  $sortASC
     * @return HasInstant[]|Instant[]
     */
    public function sortInstants(array &$objects, bool $sortASC, $maintainIndexes = false): void
    {
        $fn = static function ($object, $anotherObject) use ($sortASC): int {
            if ($object instanceof Instant) {
                $compareResult = $object->compareTo($anotherObject);
            } elseif ($object instanceof HasInstant) {
                $compareResult = $object->getInstant()->compareTo($anotherObject->getInstant());
            } else {
                throw new \InvalidArgumentException();
            }

            if ($compareResult->isEqual()) {
                return 0;
            }

            if ($sortASC) {
                return $compareResult->isLess() ? -1 : 1;
            }

            return $compareResult->isLess() ? 1 : -1;
        };

        if ($maintainIndexes) {
            uasort($objects, $fn);
        } else {
            usort($objects, $fn);
        }
    }

    public function sortPeriods(Periods $periods, int $sort = SORT_ASC): Periods
    {
        $this->checkSortParam($sort);

        $periodsArray = $periods->toArray();
        usort(
            $periodsArray,
            function (Period $onePeriod, Period $anotherPeriod) {
                $startAnotherPeriod = $anotherPeriod->secondsScale()->start();
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