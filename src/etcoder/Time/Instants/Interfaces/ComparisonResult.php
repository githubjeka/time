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

namespace etcoder\Time\Instants\Interfaces;

/**
 * Total results of comparing on the same objects
 */
interface ComparisonResult
{
    public function isLess(): bool;

    public function isNotLess(): bool;

    public function isMore(): bool;

    public function isNotMore(): bool;

    public function isEqual(): bool;

    public function isNotEqual(): bool;
}