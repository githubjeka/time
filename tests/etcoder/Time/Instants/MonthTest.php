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

use DateTime;
use DateTimeImmutable;
use etcoder\Time\Instants\Internal\DaysOfMonth;
use PHPUnit\Framework\TestCase;

class MonthTest extends TestCase
{
    public function testBuilder()
    {
        $builder = Month::builder();
        $this->assertInstanceOf(Month::class, $builder->now());
        $this->assertInstanceOf(Month::class, $builder->byDatetime(new DateTime()));
        $this->assertInstanceOf(Month::class, $builder->byDatetime(new DateTimeImmutable()));
        $this->assertInstanceOf(Month::class, $builder->byIntParams((int)date('Y'), (int)date('m')));
    }

    public function testEstimate()
    {
        $month = Month::builder()->byIntParams(2000, 1);
        $otherMonth = Month::builder()->byIntParams(2000, 2);

        $this->assertTrue($month->compareTo($otherMonth)->isLess());
        $this->assertFalse($otherMonth->compareTo($month)->isLess());

        $this->assertTrue($otherMonth->compareTo($month)->isNotLess());
        $this->assertFalse($month->compareTo($otherMonth)->isNotLess());

        $this->assertTrue($otherMonth->compareTo($month)->isMore());
        $this->assertFalse($month->compareTo($otherMonth)->isMore());

        $this->assertTrue($month->compareTo($otherMonth)->isNotMore());
        $this->assertFalse($otherMonth->compareTo($month)->isNotMore());

        $copyMonth = Month::builder()->byIntParams(2000, 1);

        $this->assertFalse($month->compareTo($otherMonth)->isEqual());
        $this->assertFalse($otherMonth->compareTo($month)->isEqual());
        $this->assertTrue($month->compareTo($copyMonth)->isEqual());

        $this->assertFalse($month->compareTo($copyMonth)->isNotEqual());
        $this->assertTrue($month->compareTo($otherMonth)->isNotEqual());
        $this->assertTrue($otherMonth->compareTo($month)->isNotEqual());
    }

    public function testInstant()
    {
        $month = Month::builder()->byIntParams(2000, 1);

        $this->assertInstanceOf(Month::class, $month->next());
        $this->assertEquals(2, $month->next()->number());
        $this->assertEquals(2000, $month->next()->year()->number());

        $month = Month::builder()->byIntParams(2000, 12);

        $this->assertInstanceOf(Month::class, $month->next());
        $this->assertEquals(1, $month->next()->number());
        $this->assertEquals(2001, $month->next()->year()->number());

        $month = Month::builder()->byIntParams(2000, 1);

        $this->assertInstanceOf(Month::class, $month->next());
        $this->assertEquals(12, $month->previous(1)->number());
        $this->assertEquals(1999, $month->previous(1)->year()->number());
        $this->assertEquals(8, $month->previous(5)->number());
        $this->assertEquals(1999, $month->previous(5)->year()->number());

        $month = Month::builder()->byIntParams(2000, 12);

        $this->assertInstanceOf(Month::class, $month->next());
        $this->assertEquals(11, $month->previous(1)->number());
        $this->assertEquals(2000, $month->previous(1)->year()->number());

        $this->assertEquals(6, $month->previous(6)->number());
        $this->assertEquals(6, $month->next(6)->number());
        $this->assertEquals(2001, $month->next(6)->year()->number());
    }

    public function testSeason()
    {
        $month = Month::builder()->byIntParams(2000, 1);
        $this->assertTrue($month->isWinter());
        $this->assertTrue($month->isNotAutumn());
        $this->assertTrue($month->isNotSpring());
        $this->assertTrue($month->isNotSummer());
        $this->assertFalse($month->isSpring());
        $this->assertFalse($month->isAutumn());
        $this->assertFalse($month->isSummer());
    }

    public function testDaysOfMonth()
    {
        $month = Month::builder()->byIntParams(2000, 1);
        $this->assertInstanceOf(DaysOfMonth::class, $month->days());
        $this->assertInstanceOf(Day::class, $month->days()->first());
        $this->assertEquals(1, $month->days()->first()->number());
        $this->assertEquals(1, $month->days()->first()->month()->number());
        $this->assertEquals(2000, $month->days()->first()->year()->number());

        $this->assertEquals(31, $month->days()->last()->number());
        $this->assertEquals(1, $month->days()->last()->month()->number());
        $this->assertEquals(2000, $month->days()->last()->year()->number());

        $this->assertEquals(31, $month->days()->amount());
    }
}
