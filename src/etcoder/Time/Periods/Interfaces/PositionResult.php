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

namespace etcoder\Time\Periods\Interfaces;

/**
 * Total results of position for Instant and Period
 */
interface PositionResult
{
    public function instantIsBefore(): bool;
    public function instantIsNotBefore(): bool;
    public function periodIsBefore(): bool;
    public function periodIsNotBefore(): bool;
    public function instantIsAfter(): bool;
    public function instantIsNotAfter(): bool;
    public function periodIsAfter(): bool;
    public function periodIsNotAfter(): bool;
    public function contain(): bool;
    public function notContain(): bool;
    public function atStart(): bool;
    public function notAtStart(): bool;
    public function atBound(): bool;
    public function notAtBound(): bool;
    public function atEnd(): bool;
    public function notAtEnd(): bool;
    public function isBetween(): bool;
    public function isNotBetween(): bool;
}