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


use etcoder\Time\Instants\Internal\Instant;

/**
 * Describe period from start Instant to end Instant
 */
abstract class Period
{
    protected $startInstant;
    protected $endInstant;

    final public function startInstant(): Instant
    {
        return $this->startInstant;
    }

    final public function endInstant(): Instant
    {
        return $this->endInstant;
    }

    final public function iterator()
    {
        return $this->startInstant()->iteratorTo($this->endInstant());
    }

    final public function array(): array
    {
        return $this->startInstant()->arrayTo($this->endInstant());
    }
}