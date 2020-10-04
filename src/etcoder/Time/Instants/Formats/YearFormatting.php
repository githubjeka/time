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

namespace etcoder\Time\Instants\Formats;

use etcoder\Time\Instants\Year;

final class YearFormatting
{
    private $year;

    public function __construct(Year $year)
    {
        $this->year = $year;
    }

    /**
     * String "YYYY" in the basic format. Extended not using
     * https://en.wikipedia.org/wiki/ISO_8601
     */
    public function toBasic(): string
    {
        return (string)$this->year->number();
    }
}