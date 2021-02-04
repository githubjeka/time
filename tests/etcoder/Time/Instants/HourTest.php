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

class HourTest extends TestCase
{
    public function testBuilder()
    {
        $builder = Hour::builder();
        $this->assertEquals(15, $builder->today(15)->value());

        $day = Day::builder()->byIntParams(2020, 12, 1);
        $this->assertEquals(24, $builder->endDay($day)->value());
        $this->assertEquals(00, $builder->midnightDay($day)->value());
        $this->assertEquals(15, $builder->hourOfDay($day, 15)->value());
    }

    public function testCompare()
    {
        $day = Day::builder()->now();
        $hour = Hour::builder()->hourOfDay($day, 16);
        $otherHour = Hour::builder()->hourOfDay($day, 17);

        $this->assertFalse($hour->compareTo($otherHour)->isEqual());
        $this->assertFalse($otherHour->compareTo($hour)->isEqual());

        $this->assertTrue($hour->compareTo($otherHour)->isNotEqual());
        $this->assertTrue($otherHour->compareTo($hour)->isNotEqual());

        $this->assertTrue($hour->compareTo($otherHour)->isLess());
        $this->assertFalse($otherHour->compareTo($hour)->isLess());

        $this->assertFalse($hour->compareTo($otherHour)->isNotLess());
        $this->assertTrue($otherHour->compareTo($hour)->isNotLess());

        $this->assertFalse($hour->compareTo($otherHour)->isMore());
        $this->assertTrue($otherHour->compareTo($hour)->isMore());

        $this->assertTrue($hour->compareTo($otherHour)->isNotMore());
        $this->assertFalse($otherHour->compareTo($hour)->isNotMore());
    }
}
