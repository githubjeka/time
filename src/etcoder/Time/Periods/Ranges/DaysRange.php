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

namespace etcoder\Time\Periods\Ranges;

use etcoder\Time\Instants\Day;
use Generator;

/**
 * Describes period of time.
 */
final class DaysRange
{
    private $start;
    private $end;

    public function __construct(Day $start, Day $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function start(): Day
    {
        return $this->start;
    }

    public function end(): Day
    {
        return $this->end;
    }

    /**
     * @return Generator|Day[]
     */
    public function iterator()
    {
        return $this->start()->iteratorTo($this->end());
    }

    /**
     * @return Day[]
     */
    public function array(): array
    {
        return $this->start()->arrayTo($this->end());
    }
}