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

use etcoder\Time\Instants\Interfaces\Instant as InstantInterface;
use etcoder\Time\Instants\Iterators\IteratorInstant;
use Generator;

trait Iterator
{
    /**
     * @param InstantInterface $instant
     * @param int $step
     * @return InstantInterface[]|Generator
     */
    final public function iteratorTo(InstantInterface $instant, int $step = 1)
    {
        $this->checkTypeInstant($instant);
        $iterator = new IteratorInstant();
        return $iterator->list($this->getInstant(), $instant, $step);
    }

    /**
     * @param InstantInterface $instant
     * @param int $step
     * @return Instant[]
     */
    final public function arrayTo(InstantInterface $instant, int $step = 1): array
    {
        $this->checkTypeInstant($instant);
        $iterator = new IteratorInstant();
        return $iterator->array($this->getInstant(), $instant, $step);
    }

    abstract protected function getInstant(): InstantInterface;

    abstract protected function checkTypeInstant(InstantInterface $otherInstant);
}