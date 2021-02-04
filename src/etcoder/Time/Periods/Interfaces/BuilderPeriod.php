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

namespace etcoder\Time\Periods\Interfaces;


use etcoder\Time\Instants\Month;
use etcoder\Time\Instants\Year;
use etcoder\Time\Periods\Period;

/**
 * Describer methods for more efficient create Period model
 */
interface BuilderPeriod
{
    public function byMonth(Month $month): Period;

    public function byYear(Year $year): Period;

    public function currentMonth(): Period;

    public function currentYear(): Period;
}