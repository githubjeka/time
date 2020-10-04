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

use etcoder\Time\Instants\Day;

/**
 * Describes Days of Month
 */
interface Days
{
    /**
     * Provides first Day of Month
     */
    public function first(): Day;

    /**
     * Provides last Day of Month
     */
    public function last(): Day;

    /**
     * Provides number of last Day
     */
    public function lastNumber(): int;

    /**
     * Provides quantity of Days for Month
     */
    public function amount(): int;
}