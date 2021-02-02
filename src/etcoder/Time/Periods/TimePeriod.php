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

namespace etcoder\Time\Periods;

use etcoder\Time\Instants\TimePoint;
use etcoder\Time\Periods\Builders\BuilderTime;
use Generator;

/**
 * Describes period of time.
 *
 * Note: Seconds is the default smallest Instant when you work with iterator.
 * @method TimePoint[] array()
 * @method Generator|TimePoint[] iterator()
 * @method TimePoint startInstant()
 * @method TimePoint endInstant()
 */
final class TimePeriod extends Period
{
    public function __construct(TimePoint $startInstant, TimePoint $endInstant)
    {
        $this->startInstant = $startInstant;
        $this->endInstant = $endInstant;
    }

    public static function builder(): BuilderTime
    {
        return new BuilderTime();
    }
}