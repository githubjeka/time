<?php

declare(strict_types=1);

namespace etcoder\Time\Periods;


use etcoder\Time\Calculations\Calculator;
use etcoder\Time\Instants\Day;
use etcoder\Time\Instants\Instants;
use etcoder\Time\Instants\Month;
use etcoder\Time\Instants\Time;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    public function testSplit()
    {
        $month = Month::builder()->byIntParams(2021, 01);
        $criticalDay = Day::builder()->ofMonth($month, 15);

        $instants = new Instants(
            Time::builder()->midnightDay($criticalDay)
        );

        $calculator = new Calculator();
        $splitPeriods = $calculator->split($month->asPeriod(), ...$instants);

        $this->assertCount(2, $splitPeriods);

        [$firstPeriod, $secondPeriod] = $splitPeriods;

        /** @var Period $firstPeriod */
        /** @var Period $secondPeriod */

        $this->assertTrue($month->firstDay()->compareTo($firstPeriod->dayScale()->start())->isEqual());
        $this->assertTrue($criticalDay->compareTo($firstPeriod->dayScale()->end())->isEqual());
        $this->assertTrue($criticalDay->compareTo($secondPeriod->dayScale()->start())->isEqual());
        $this->assertTrue($month->lastDay()->compareTo($secondPeriod->dayScale()->end())->isEqual());
    }

    public function testRanges()
    {
        $timePeriod1 = new Period(
            Time::builder()->today(15, 0, 0),
            Time::builder()->today(20, 0, 0)
        );

        $timePeriod2 = new Period(
            Time::builder()->today(14, 0, 0),
            Time::builder()->today(21, 0, 0)
        );

        $calculator = new Calculator();
        $overlap = $calculator->overlap($timePeriod1, $timePeriod2);
        $this->assertTrue($overlap->hasOverlap());
        $this->assertEquals(15, $overlap->value()->hourScale()->start()->value());
        $this->assertEquals(20, $overlap->value()->hourScale()->end()->value());

        $overlap = $calculator->overlap($timePeriod2, $timePeriod1);
        $this->assertTrue($overlap->hasOverlap());
        $this->assertEquals(15, $overlap->value()->hourScale()->start()->value());
        $this->assertEquals(20, $overlap->value()->hourScale()->end()->value());
    }

    public function testVariousRanges()
    {
        $timePeriod1 = new Period(
            Time::builder()->today(15, 0, 0),
            Time::builder()->today(16, 0, 0)
        );

        $timePeriod2 = new Period(
            Time::builder()->today(17, 0, 0),
            Time::builder()->today(21, 0, 0)
        );
        $calculator = new Calculator();
        $overlap = $calculator->overlap($timePeriod1, $timePeriod2);
        $this->assertFalse($overlap->hasOverlap());
        $overlap = $calculator->overlap($timePeriod2, $timePeriod1);
        $this->assertFalse($overlap->hasOverlap());
    }

    public function testStartSameRanges()
    {
        $timePeriod1 = new Period(
            Time::builder()->today(15, 0, 0),
            Time::builder()->today(16, 0, 0)
        );

        $timePeriod2 = new Period(
            Time::builder()->today(15, 0, 0),
            Time::builder()->today(17, 0, 0)
        );
        $calculator = new Calculator();
        $overlap = $calculator->overlap($timePeriod1, $timePeriod2);
        $this->assertTrue($overlap->hasOverlap());
        $this->assertEquals(15, $overlap->value()->hourScale()->start()->value());
        $this->assertEquals(16, $overlap->value()->hourScale()->end()->value());

        $overlap = $calculator->overlap($timePeriod2, $timePeriod1);
        $this->assertTrue($overlap->hasOverlap());
        $this->assertEquals(15, $overlap->value()->hourScale()->start()->value());
        $this->assertEquals(16, $overlap->value()->hourScale()->end()->value());
    }

    public function testEndSameRanges()
    {
        $timePeriod1 = new Period(
            Time::builder()->today(15, 0, 0),
            Time::builder()->today(16, 0, 0)
        );

        $timePeriod2 = new Period(
            Time::builder()->today(16, 0, 0),
            Time::builder()->today(17, 0, 0)
        );
        $calculator = new Calculator();
        $overlap = $calculator->overlap($timePeriod1, $timePeriod2);
        $this->assertFalse($overlap->hasOverlap());
        $overlap = $calculator->overlap($timePeriod2, $timePeriod1);
        $this->assertFalse($overlap->hasOverlap());
    }
}