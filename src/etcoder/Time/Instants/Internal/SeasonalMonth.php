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

    public function isNotWinter(): bool
    {
        return !$this->isWinter();
    }

    public function isWinter(): bool
    {
        $n = $this->getMonth()->number();
        return $n === 12 || $n === 1 || $n === 2;
    }

    public function isNotSpring(): bool
    {
        return !$this->isSpring();
    }

    public function isSpring(): bool
    {
        $n = $this->getMonth()->number();
        return $n === 3 || $n === 4 || $n === 5;
    }

    public function isNotSummer(): bool
    {
        return !$this->isSummer();
    }

    public function isSummer(): bool
    {
        $n = $this->getMonth()->number();
        return $n === 6 || $n === 7 || $n === 8;
    }

    public function isNotAutumn(): bool
    {
        return !$this->isAutumn();
    }

    public function isAutumn(): bool
    {
        $n = $this->getMonth()->number();
        return $n === 9 || $n === 10 || $n === 11;
    }
}