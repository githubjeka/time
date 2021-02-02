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

use etcoder\Time\Instants\Month;

trait SeasonalMonth
{
    abstract protected function getMonth(): Month;

    final public function isNotWinter(): bool
    {
        return !$this->isWinter();
    }

    final public function isWinter(): bool
    {
        $n = $this->getMonth()->number();
        return $n === 12 || $n === 1 || $n === 2;
    }

    final public function isNotSpring(): bool
    {
        return !$this->isSpring();
    }

    final public function isSpring(): bool
    {
        $n = $this->getMonth()->number();
        return $n === 3 || $n === 4 || $n === 5;
    }

    final public function isNotSummer(): bool
    {
        return !$this->isSummer();
    }

    final public function isSummer(): bool
    {
        $n = $this->getMonth()->number();
        return $n === 6 || $n === 7 || $n === 8;
    }

    final public function isNotAutumn(): bool
    {
        return !$this->isAutumn();
    }

    final public function isAutumn(): bool
    {
        $n = $this->getMonth()->number();
        return $n === 9 || $n === 10 || $n === 11;
    }
}