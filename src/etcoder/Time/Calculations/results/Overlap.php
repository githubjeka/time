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

namespace etcoder\Time\Calculations\results;

use etcoder\Time\Periods\Period;

final class Overlap
{
    /**
     * @var Period|null
     */
    private $overlapResult;

    public function __construct(?Period $overlapResult)
    {
        $this->overlapResult = $overlapResult;
    }

    public static function null(): Overlap
    {
        return new Overlap(null);
    }

    public function hasOverlap(): bool
    {
        return $this->overlapResult !== null;
    }

    public function withoutOverlap(): bool
    {
        return $this->overlapResult === null;
    }

    public function value(): Period
    {
        if ($this->overlapResult === null) {
            throw new \LogicException('without overlap');
        }

        return $this->overlapResult;
    }
}