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
 * Generalized description of the moments, like months, years, days
 */
interface Instant
{
    public function next(int $step = 1);

    public function previous(int $step = 1);

    /**
     * Comparison method for Instant objects
     */
    public function compareTo(Instant $otherInstant): ComparisonResult;
}