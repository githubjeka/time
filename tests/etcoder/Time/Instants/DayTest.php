<?php

/**
 * This file is part of the etcoder/Time package.
 *
 * Evgeniy Tkachenko <et.coder@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace etcoder\Time\Instants;

use etcoder\Time\Instants\Interfaces\Instant;
use PHPUnit\Framework\TestCase;

use function etcoder\Time\Instants\Builders\day_by_datetime;
use function etcoder\Time\Instants\Builders\day_by_string;
use function etcoder\Time\Instants\Builders\today;
use function etcoder\Time\Instants\Builders\tomorrow;
use function etcoder\Time\Instants\Builders\yesterday;

class DayTest extends TestCase
{
    public function testBuilder()
    {
        $builder = Day::builder();
        $this->assertInstanceOf(Day::class, $builder->byDatetime(new \DateTime()));
        $this->assertInstanceOf(Day::class, $builder->byDatetime(new \DateTimeImmutable()));
        $this->assertInstanceOf(Day::class, $builder->byString("2000-01-20"));
        $this->assertInstanceOf(Day::class, $builder->byString("20000120"));
        $this->assertInstanceOf(Day::class, $builder->byIntParams(2000, 1, 4));
        $this->assertInstanceOf(Day::class, $builder->today());
        $this->assertInstanceOf(Day::class, today());
        $this->assertInstanceOf(Day::class, tomorrow());
        $this->assertInstanceOf(Day::class, yesterday());
        $this->assertInstanceOf(Day::class, day_by_string('2021-01-31'));
        $this->assertInstanceOf(Day::class, day_by_datetime(new \DateTime()));

        $today = new \DateTime();
        $this->assertEquals($today->format('Y'), today()->year()->number());
        $this->assertEquals($today->format('m'), today()->month()->number());
        $this->assertEquals($today->format('d'), today()->number());

        $day = $builder->byString("20000120");

        $this->assertEquals(20, $day->number());
        $this->assertInstanceOf(Month::class, $day->month());
        $this->assertEquals(1, $day->month()->number());
        $this->assertEquals(2000, $day->year()->number());

        $day = $builder->byIntParams(2000, 1, 5);

        $this->assertEquals(5, $day->number());
        $this->assertEquals(1, $day->month()->number());
        $this->assertEquals(2000, $day->year()->number());

        $day = $builder->byIntParams(69, 1, 5);

        $this->assertEquals(5, $day->number());
        $this->assertEquals(1, $day->month()->number());
        $this->assertEquals(2069, $day->year()->number());

        $day = $builder->byIntParams(99, 1, 5);

        $this->assertEquals(5, $day->number());
        $this->assertEquals(1, $day->month()->number());
        $this->assertEquals(1999, $day->year()->number());
    }

    public function testInstant()
    {
        $day = Day::builder()->byIntParams(2000, 1, 1);
        $this->assertInstanceOf(Instant::class, $day);
        $this->assertTrue($day->isSaturday());

        $this->assertEquals(1999, $day->previous(1)->year()->number());
        $this->assertEquals(12, $day->previous(1)->month()->number());
        $this->assertEquals(31, $day->previous(1)->number());

        $this->assertEquals(2000, $day->next()->year()->number());
        $this->assertEquals(1, $day->next()->month()->number());
        $this->assertEquals(2, $day->next()->number());

        $this->assertEquals(1, $day->next(-1)->number());
        $this->assertEquals(1, $day->next(0)->number());
        $this->assertEquals(31, $day->next(30)->number());
        $this->assertEquals(1, $day->next(60)->number());
        $this->assertEquals(3, $day->next(60)->month()->number());

        $this->assertEquals(1, $day->previous(-1)->number());
        $this->assertEquals(1, $day->previous(0)->number());
        $this->assertEquals(2, $day->previous(30)->number());
        $this->assertEquals(2, $day->previous(60)->number());
        $this->assertEquals(11, $day->previous(60)->month()->number());
    }

    public function testCompare()
    {
        $day = Day::builder()->byIntParams(2021,1,1);
        $otherDay = Day::builder()->byIntParams(2021,1,4);

        $this->assertFalse($day->compareTo($otherDay)->isEqual());
        $this->assertFalse($otherDay->compareTo($day)->isEqual());

        $this->assertTrue($day->compareTo($otherDay)->isNotEqual());
        $this->assertTrue($otherDay->compareTo($day)->isNotEqual());

        $this->assertTrue($day->compareTo($otherDay)->isLess());
        $this->assertFalse($otherDay->compareTo($day)->isLess());

        $this->assertFalse($day->compareTo($otherDay)->isNotLess());
        $this->assertTrue($otherDay->compareTo($day)->isNotLess());

        $this->assertFalse($day->compareTo($otherDay)->isMore());
        $this->assertTrue($otherDay->compareTo($day)->isMore());

        $this->assertTrue($day->compareTo($otherDay)->isNotMore());
        $this->assertFalse($otherDay->compareTo($day)->isNotMore());

        $day = Day::builder()->byIntParams(2000, 1, 1);
        $copyDay = Day::builder()->byIntParams(2000, 1, 1);

        $this->assertTrue($day->compareTo($copyDay)->isEqual());
        $this->assertFalse($day->compareTo($copyDay)->isNotEqual());

        $day = Day::builder()->byIntParams(2021,1,31);
        $otherDay = Day::builder()->byIntParams(2020,12,1);

        $this->assertFalse($day->compareTo($otherDay)->isLess());
    }

    public function testSeason()
    {
        $day = Day::builder()->byIntParams(2000, 1, 1);
        $this->assertTrue($day->isWinter());
        $this->assertTrue($day->isNotAutumn());
        $this->assertTrue($day->isNotSpring());
        $this->assertTrue($day->isNotSummer());
        $this->assertFalse($day->isSpring());
        $this->assertFalse($day->isAutumn());
        $this->assertFalse($day->isSummer());
    }

    public function testAnalyze()
    {
        $day = Day::builder()->byIntParams(2000, 1, 1);
        $this->assertFalse($day->isLastDayMonth());
        $this->assertTrue($day->isFirstDayMonth());
    }

    public function testComparisonOperators()
    {
        $day = Day::builder()->byIntParams(2021,12,7);
        $otherDay = Day::builder()->byIntParams(2022,3,4);
        $this->assertFalse($day == $otherDay);
        $this->assertFalse($day === $otherDay);
        $this->assertTrue($day < $otherDay);
        $this->assertFalse($day > $otherDay);

        $day = Day::builder()->byIntParams(2023,1,2);
        $otherDay = Day::builder()->byIntParams(2022,3,2);
        $this->assertFalse($day == $otherDay);
        $this->assertFalse($day === $otherDay);
        $this->assertTrue($day > $otherDay);
        $this->assertFalse($day < $otherDay);

        $day = Day::builder()->byIntParams(2021,12,7);
        $otherDay = Day::builder()->byIntParams(2021,12,7);
        $this->assertTrue($day == $otherDay);
        $this->assertFalse($day === $otherDay);

        $day = Day::builder()->byIntParams(2021,12,7);
        $otherDay = $day;
        $this->assertTrue($day == $otherDay);
        $this->assertTrue($day === $otherDay);
    }
}
