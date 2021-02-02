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

namespace etcoder\Time\Instants\Builders;

use etcoder\Time\Instants\{Interfaces\BuilderMonth as BuilderMonthInterface, Month, Year};

final class BuilderMonth implements BuilderMonthInterface
{
    /**
     * Returns Month according to integers values of number year and month
     */
    public function byIntParams(int $year, int $month): Month
    {
        $year = new Year($year);
        return new Month($year, $month);
    }

    /**
     * Returns Month by PHP DateTime object
     */
    public function byDatetime(\DateTimeInterface $dateTime): Month
    {
        $year = new Year((int)$dateTime->format('Y'));
        return new Month($year, (int)$dateTime->format('m'));
    }

    /**
     * Returns current Month
     */
    public function now(): Month
    {
        return new Month(Year::builder()->now(), (int)date('m'));
    }
}