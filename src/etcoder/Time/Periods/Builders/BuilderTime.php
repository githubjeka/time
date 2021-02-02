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

namespace etcoder\Time\Periods\Builders;


use etcoder\Time\Instants\Month;
use etcoder\Time\Instants\TimePoint;
use etcoder\Time\Periods\TimePeriod;

/**
 * Contains methods for more efficient create TimePeriod model
 */
final class BuilderTime
{
    public function month(Month $month): TimePeriod
    {
        $startPoint = TimePoint::builder()->midnightDay($month->days()->first());
        $endPoint = TimePoint::builder()->endDay($month->days()->last());
        return new TimePeriod($startPoint, $endPoint);
    }
}