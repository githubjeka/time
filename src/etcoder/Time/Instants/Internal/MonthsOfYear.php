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

namespace etcoder\Time\Instants\Internal;

use etcoder\Time\Instants\Month;
use etcoder\Time\Instants\Year;

final class MonthsOfYear
{
    private $year;

    public function __construct(Year $year)
    {
        $this->year = $year;
    }

    public function january(): Month
    {
        return new Month($this->year, 1);
    }

    public function february(): Month
    {
        return new Month($this->year, 2);
    }

    public function march(): Month
    {
        return new Month($this->year, 3);
    }

    public function april(): Month
    {
        return new Month($this->year, 4);
    }

    public function may(): Month
    {
        return new Month($this->year, 5);
    }

    public function june(): Month
    {
        return new Month($this->year, 6);
    }

    public function july(): Month
    {
        return new Month($this->year, 7);
    }

    public function august(): Month
    {
        return new Month($this->year, 8);
    }

    public function september(): Month
    {
        return new Month($this->year, 9);
    }

    public function october(): Month
    {
        return new Month($this->year, 10);
    }

    public function november(): Month
    {
        return new Month($this->year, 11);
    }

    public function december(): Month
    {
        return new Month($this->year, 12);
    }
}