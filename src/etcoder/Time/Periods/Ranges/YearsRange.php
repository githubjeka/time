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

use etcoder\Time\Instants\Year;
use \Generator;

/**
 * Describes period by years.
 */
final class YearsRange
{
    private $start;
    private $end;

    public function __construct(Year $start, Year $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function start(): Year
    {
        return $this->start;
    }

    public function end(): Year
    {
        return $this->end;
    }

    /**
     * @return Generator|Year[]
     */
    public function iterator()
    {
        return $this->start()->iteratorTo($this->end());
    }

    /**
     * @return Year[]
     */
    public function array(): array
    {
        return $this->start()->arrayTo($this->end());
    }
}