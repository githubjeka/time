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

namespace etcoder\Time\Instants;

use etcoder\Time\Instants\Builders\BuilderYear;
use etcoder\Time\Instants\Formats\YearFormatting;
use etcoder\Time\Instants\Interfaces\ComparisonResult;
use etcoder\Time\Instants\Internal\Comparison\YearsComparison;
use Generator;
use InvalidArgumentException;

/**
 * @method Year[] arrayTo(Year $year, int $step = 1)
 * @method Generator|Year[] iteratorTo(Year $year, int $step = 1)
 * @method ComparisonResult compareTo(Year $year)
 */
final class Year extends Internal\Instant
{
    private int $number;

    public function __construct(int $number)
    {
        if ($number < 1 || $number > 32767) {
            throw new InvalidArgumentException("Wrong Year value $number");
        }
        $this->number = $number;
    }

    public static function builder(): BuilderYear
    {
        return new BuilderYear();
    }

    public function next(int $step = 1): Year
    {
        $number = $this->number() + $step;
        return new Year($number);
    }

    public function number(): int
    {
        return $this->number;
    }

    public function previous(int $step = 1): Year
    {
        $number = $this->number() - $step;
        return new Year($number);
    }

    public function format(): YearFormatting
    {
        return new YearFormatting($this);
    }

    /**
     * @param Interfaces\Instant|Year $instant
     * @return ComparisonResult
     */
    protected function comparisonResult(Interfaces\Instant $instant): ComparisonResult
    {
        return new YearsComparison($this, $instant);
    }
}