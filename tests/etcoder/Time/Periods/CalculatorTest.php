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
        $criticalDay = Day::builder()->dayOfMonth($month, 15);

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
}