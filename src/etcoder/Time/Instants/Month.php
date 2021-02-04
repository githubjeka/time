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

namespace etcoder\Time\Instants;

use etcoder\Time\Instants\Builders\BuilderMonth;
use etcoder\Time\Instants\Formats\MonthFormatting;
use etcoder\Time\Instants\Interfaces\{BuilderMonth as BuilderMonthInterface, ComparisonResult, Days};
use etcoder\Time\Instants\Internal\{Comparison\MonthsComparison, DaysOfMonth, Instant, SeasonalMonth};
use etcoder\Time\Periods\Period;

/**
 * @method Month[] arrayTo(Month $month, int $step = 1)
 * @method \Generator|Month[] iteratorTo(Month $month, int $step = 1)
 * @method ComparisonResult compareTo(Month $month)
 */
final class Month extends Instant
{
    use SeasonalMonth;

    private $year;
    private $numberMonth;

    public function __construct(Year $year, int $numberMonth)
    {
        $this->year = $year;

        if ($numberMonth > 12 || $numberMonth < 1) {
            throw new \InvalidArgumentException();
        }

        $this->numberMonth = $numberMonth;
    }

    /**
     * Provides a flexible way to create Month object
     */
    public static function builder(): BuilderMonthInterface
    {
        return new BuilderMonth();
    }

    public function year(): Year
    {
        return $this->year;
    }

    /**
     * Provides days for this Month
     * @deprecated
     */
    public function days(): Days
    {
        return new DaysOfMonth($this);
    }

    public function firstDay(): Day
    {
        return $this->asPeriod()->dayScale()->start();
    }

    public function lastDay(): Day
    {
        return $this->asPeriod()->dayScale()->end();
    }

    public function asPeriod(): Period
    {
        return Period::builder()->byMonth($this);
    }

    public function format(): MonthFormatting
    {
        return new MonthFormatting($this);
    }

    public function next(int $step = 1): Month
    {
        $numberMonth = $this->number();
        $year = $this->year;
        do {
            if ($numberMonth === 12) {
                $numberMonth = 1;
                $year = $year->next();
            } else {
                $numberMonth++;
            }
            $step--;
        } while ($step !== 0);
        return new Month($year, $numberMonth);
    }

    public function number(): int
    {
        return $this->numberMonth;
    }

    public function previous(int $step = 1): Month
    {
        $numberMonth = $this->number();
        $year = $this->year;
        do {
            if ($numberMonth === 1) {
                $numberMonth = 12;
                $year = $year->previous();
            } else {
                $numberMonth--;
            }
            $step--;
        } while ($step !== 0);
        return new Month($year, $numberMonth);
    }

    /**
     * @param Interfaces\Instant|Month $instant
     * @return ComparisonResult
     */
    protected function comparisonResult(Interfaces\Instant $instant): ComparisonResult
    {
        return new MonthsComparison($this, $instant);
    }

    protected function getMonth(): Month
    {
        return $this;
    }
}