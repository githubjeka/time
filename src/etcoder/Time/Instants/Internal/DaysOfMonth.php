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

use etcoder\Time\Instants\Day;
use etcoder\Time\Instants\Interfaces\Days;
use etcoder\Time\Instants\Month;

final class DaysOfMonth implements Days
{
    private $month;

    public function __construct(Month $month)
    {
        $this->month = $month;
    }

    public function first(): Day
    {
        $date = $this->firstDayDateTime();
        return Day::builder()->byDatetime($date);
    }

    private function firstDayDateTime(): \DateTimeImmutable
    {
        return \DateTimeImmutable::createFromFormat(
            'Y-n-d',
            $this->month->year()->number() . '-' . $this->month->number() . '-01'
        );
    }

    public function last(): Day
    {
        return new Day($this->month, $this->lastNumber());
    }

    public function lastNumber(): int
    {
        return (int)$this->firstDayDateTime()->format('t');
    }

    public function amount(): int
    {
        return (int)$this->firstDayDateTime()->format('t');
    }
}