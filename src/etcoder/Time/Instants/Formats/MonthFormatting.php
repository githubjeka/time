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

use etcoder\Time\Instants\Month;

final class MonthFormatting
{
    private $month;

    public function __construct(Month $month)
    {
        $this->month = $month;
    }

    /**
     * String "YYYYMM" in the basic format
     * https://en.wikipedia.org/wiki/ISO_8601
     */
    public function toBasic(): string
    {
        $year = $this->yearAsString();
        $month = sprintf("%02d", $this->month->number());

        return "$year$month";
    }

    private function yearAsString(): string
    {
        return (string)$this->month->year()->number();
    }

    /**
     * String "YYYY-MM" in the extended format
     * https://en.wikipedia.org/wiki/ISO_8601
     */
    public function toExtended(): string
    {
        $year = $this->yearAsString();
        $month = $this->monthAsString();

        return "$year-$month";
    }

    private function monthAsString(): string
    {
        return sprintf("%02d", $this->month->number());
    }
}