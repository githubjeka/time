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

use etcoder\Time\Instants\Year;

final class BuilderYear
{
    /**
     * Returns Year by integer value
     */
    public function byInt(int $value): Year
    {
        return new Year($value);
    }

    /**
     * Returns Day by PHP DateTime object
     */
    public function byDatetime(\DateTimeInterface $dateTime): Year
    {
        return new Year((int)$dateTime->format('Y'));
    }

    /**
     * Returns current Month
     */
    public function now(): Year
    {
        $number = (int)date('Y');
        return new Year($number);
    }
}