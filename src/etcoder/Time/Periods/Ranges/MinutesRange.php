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

use etcoder\Time\Instants\Minute;

final class MinutesRange
{
    private $start;
    private $end;

    public function __construct(Minute $start, Minute $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function start(): Minute
    {
        return $this->start;
    }

    public function end(): Minute
    {
        return $this->end;
    }

    /**
     * @return Generator|Minute[]
     */
    public function iterator()
    {
        return $this->start()->iteratorTo($this->end());
    }

    /**
     * @return Minute[]
     */
    public function array(): array
    {
        return $this->start()->arrayTo($this->end());
    }
}