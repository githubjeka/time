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

namespace etcoder\Time\Format;

use etcoder\Time\Instants\Day;
use etcoder\Time\Instants\Month;
use etcoder\Time\Instants\Year;
use PHPUnit\Framework\TestCase;

class FormatInstantTest extends TestCase
{
    public function testDay()
    {
        $day = Day::builder()->byIntParams(2020, 01, 01);
        $this->assertEquals('20200101', $day->format()->toBasic());
        $this->assertEquals('2020-01-01', $day->format()->toExtended());
    }

    public function testMonth()
    {
        $month = Month::builder()->byIntParams(2020, 01);
        $this->assertEquals('202001', $month->format()->toBasic());
        $this->assertEquals('2020-01', $month->format()->toExtended());
    }

    public function testYear()
    {
        $year = Year::builder()->byInt(2020);
        $this->assertEquals('2020', $year->format()->toBasic());
    }
}