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

/**
 * Describes nominal duration of period time.
 */
final class Duration
{
    private $seconds;
    private $minutes;
    private $hours;
    private $days;
    private $months;
    private $years;

    public function __construct(
        int $seconds = 0,
        int $minutes = 0,
        int $hours = 0,
        int $days = 0,
        int $months = 0,
        int $years = 0
    ) {
        $this->seconds = $seconds;
        $this->minutes = $minutes;
        $this->hours = $hours;
        $this->days = $days;
        $this->months = $months;
        $this->years = $years;
    }
}