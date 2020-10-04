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

namespace etcoder\Time\Instants\Interfaces;

use etcoder\Time\Instants\Month;

interface BuilderMonth
{
    /**
     * Returns Month according to integers values of number year and month
     */
    public function byIntParams(int $year, int $month): Month;

    /**
     * Returns Month by PHP DateTime object
     */
    public function byDatetime(\DateTimeInterface $dateTime): Month;

    /**
     * Returns current Month
     */
    public function now(): Month;
}