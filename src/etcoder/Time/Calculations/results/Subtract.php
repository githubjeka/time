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

use etcoder\Time\Periods\Periods;

final class Subtract
{
    /**
     * @var Periods
     */
    private $result;

    public function __construct(Periods $result)
    {
        $this->result = $result;
    }

    public static function null(): Subtract
    {
        return new Subtract(new Periods());
    }

    public function periods(): Periods
    {
        return $this->result;
    }
}