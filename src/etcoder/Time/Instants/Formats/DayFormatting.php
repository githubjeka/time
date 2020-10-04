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

namespace etcoder\Time\Instants\Formats;

use etcoder\Time\Instants\Day;

final class DayFormatting
{
    private $day;

    public function __construct(Day $day)
    {
        $this->day = $day;
    }

    /**
     * String "YYYYMMDD" in the basic format
     * https://en.wikipedia.org/wiki/ISO_8601
     */
    public function toBasic(): string
    {
        $year = $this->yearAsString();
        $month = $this->monthAsString();
        $day = $this->dayAsString();

        return "$year$month$day";
    }

    /**
     * String "YYYY-MM-DD" in the extended format
     * https://en.wikipedia.org/wiki/ISO_8601
     */
    public function toExtended(): string
    {
        $year = $this->yearAsString();
        $month = $this->monthAsString();
        $day = $this->dayAsString();

        return "$year-$month-$day";
    }


    private function yearAsString(): string
    {
        return (string)$this->day->month()->year()->number();
    }

    private function monthAsString(): string
    {
        return sprintf("%02d", $this->day->month()->number());
    }

    private function dayAsString(): string
    {
        return sprintf("%02d", $this->day->number());
    }
}