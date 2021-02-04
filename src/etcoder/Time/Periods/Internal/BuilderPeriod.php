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

namespace etcoder\Time\Periods\Internal;


use etcoder\Time\Instants\Month;
use etcoder\Time\Instants\Time;
use etcoder\Time\Periods\Period;
use etcoder\Time\Periods\Interfaces\BuilderPeriod as BuilderTimeInterface;

final class BuilderPeriod implements BuilderTimeInterface
{
    public function byMonth(Month $month): Period
    {
        $startPoint = Time::builder()->midnightDay($month->days()->first());
        $endPoint = Time::builder()->endDay($month->days()->last());
        return new Period($startPoint, $endPoint);
    }
}