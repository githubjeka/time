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

use etcoder\Time\Instants\Month;
use \Generator;

/**
 * Describes period by years.
 */
final class MonthRange
{
    private $start;
    private $end;

    public function __construct(Month $start, Month $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function start(): Month
    {
        return $this->start;
    }

    public function end(): Month
    {
        return $this->end;
    }

    /**
     * @return Generator|Month[]
     */
    public function iterator()
    {
        return $this->start()->iteratorTo($this->end());
    }

    /**
     * @return Month[]
     */
    public function array(): array
    {
        return $this->start()->arrayTo($this->end());
    }
}