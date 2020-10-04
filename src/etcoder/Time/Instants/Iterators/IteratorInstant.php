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

namespace etcoder\Time\Instants\Iterators;

use etcoder\Time\Instants\Interfaces\Instant;

final class IteratorInstant
{
    /**
     * @return Instant[]
     */
    public function array(Instant $from, Instant $to, int $step = 1): array
    {
        return iterator_to_array($this->list($from, $to, $step));
    }

    /**
     * @return \Generator|Instant[]
     */
    public function list(Instant $firstInstant, Instant $lastInstant, int $step = 1)
    {
        if ($step <= 0) {
            throw new \InvalidArgumentException();
        }

        if ($lastInstant->compareTo($firstInstant)->isLess()) {
            return $this->reverseList($firstInstant, $lastInstant, $step);
        }

        return $this->forwardList($firstInstant, $lastInstant, $step);
    }

    private function forwardList(Instant $firstInstant, Instant $lastInstant, int $step)
    {
        $instant = $firstInstant;
        while ($instant->compareTo($lastInstant)->isNotMore()) {
            yield $instant;
            for ($i = 0; $i < $step; $i++) {
                $instant = $instant->next();
            }
        }
    }

    private function reverseList(Instant $firstInstant, Instant $lastInstant, int $step)
    {
        $instant = $firstInstant;
        while ($instant->compareTo($lastInstant)->isNotLess()) {
            yield $instant;
            for ($i = 0; $i < $step; $i++) {
                $instant = $instant->previous(1);
            }
        }
    }
}