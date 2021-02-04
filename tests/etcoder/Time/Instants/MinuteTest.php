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

use PHPUnit\Framework\TestCase;

class MinuteTest extends TestCase
{
    public function testBuilder()
    {
        $builder = Minute::builder();
        $this->assertEquals(05, $builder->today(15, 05)->value());

        $day = Day::builder()->byIntParams(2020, 12, 1);
        $this->assertEquals(00, $builder->endDay($day)->value());
        $this->assertEquals(00, $builder->midnightDay($day)->value());
    }

    public function testCompare()
    {
        $minute = Minute::builder()->today(16, 01);
        $otherMinute = Minute::builder()->today(16, 02);

        $this->assertFalse($minute->compareTo($otherMinute)->isEqual());
        $this->assertFalse($otherMinute->compareTo($minute)->isEqual());

        $this->assertTrue($minute->compareTo($otherMinute)->isNotEqual());
        $this->assertTrue($otherMinute->compareTo($minute)->isNotEqual());

        $this->assertTrue($minute->compareTo($otherMinute)->isLess());
        $this->assertFalse($otherMinute->compareTo($minute)->isLess());

        $this->assertFalse($minute->compareTo($otherMinute)->isNotLess());
        $this->assertTrue($otherMinute->compareTo($minute)->isNotLess());

        $this->assertFalse($minute->compareTo($otherMinute)->isMore());
        $this->assertTrue($otherMinute->compareTo($minute)->isMore());

        $this->assertTrue($minute->compareTo($otherMinute)->isNotMore());
        $this->assertFalse($otherMinute->compareTo($minute)->isNotMore());
    }
}
