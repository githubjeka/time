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

use etcoder\Time\Instants\Iterators\IteratorInstant;
use PHPUnit\Framework\TestCase;

class YearTest extends TestCase
{
    public function testBuilder()
    {
        $builder = Year::builder();
        $this->assertInstanceOf(Year::class, $builder->now());
        $this->assertInstanceOf(Year::class, $builder->byDatetime(new \DateTime()));
        $this->assertInstanceOf(Year::class, $builder->byDatetime(new \DateTimeImmutable()));
        $this->assertInstanceOf(Year::class, $builder->byInt(2000));
    }

    public function testInstant()
    {
        $year = new Year(2000);

        $this->assertEquals(2001, $year->next()->number());
        $this->assertEquals(2030, $year->next(30)->number());
        $this->assertEquals(1999, $year->previous()->number());
        $this->assertEquals(1995, $year->previous(5)->number());
    }

    public function testIterator()
    {
        $year = new Year(2000);
        $iterator = new IteratorInstant();
        $array = $iterator->array($year, $year->next(5));
        $this->assertCount(6, $array);
    }

    public function testEstimate()
    {
        $year = new Year(2000);
        $otherYear = new Year(2001);
        $copyYear = new Year(2000);

        $this->assertTrue($year->compareTo($otherYear)->isLess());
        $this->assertFalse($otherYear->compareTo($year)->isLess());

        $this->assertTrue($otherYear->compareTo($year)->isNotLess());
        $this->assertFalse($year->compareTo($otherYear)->isNotLess());

        $this->assertTrue($otherYear->compareTo($year)->isMore());
        $this->assertFalse($year->compareTo($otherYear)->isMore());

        $this->assertTrue($year->compareTo($otherYear)->isNotMore());
        $this->assertFalse($otherYear->compareTo($year)->isNotMore());

        $this->assertFalse($year->compareTo($otherYear)->isEqual());
        $this->assertFalse($otherYear->compareTo($year)->isEqual());
        $this->assertTrue($year->compareTo($copyYear)->isEqual());

        $this->assertFalse($year->compareTo($copyYear)->isNotEqual());
        $this->assertTrue($year->compareTo($otherYear)->isNotEqual());
        $this->assertTrue($otherYear->compareTo($year)->isNotEqual());
    }

    public function testMonthsOfYear()
    {
        $year = new Year(2000);

        $this->assertEquals(2000, $year->months()->january()->year()->number());
        $this->assertEquals(1, $year->months()->january()->number());
        $this->assertEquals(1, $year->months()->january()->days()->first()->number());
    }
}
