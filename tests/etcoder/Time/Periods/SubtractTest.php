<?php

declare(strict_types=1);

namespace etcoder\Time\Periods;


use etcoder\Time\Calculations\Calculator;
use etcoder\Time\Instants\Time;
use PHPUnit\Framework\TestCase;

class SubtractTest extends TestCase
{
    /**
     * [              ]
     *    [       ]
     */
    public function testSubtract1()
    {
        $timePeriod1 = new Period(
            Time::builder()->today(15, 0, 0),
            Time::builder()->today(20, 0, 0)
        );

        $timePeriod2 = new Period(
            Time::builder()->today(16, 0, 0),
            Time::builder()->today(17, 0, 0)
        );

        $calculator = new Calculator();
        $subtract = $calculator->subtract($timePeriod1, $timePeriod2);
        $this->assertFalse($subtract->periods()->isEmpty());
        $this->assertEquals(2, $subtract->periods()->count());
        $this->assertEquals(15, $subtract->periods()->offsetGet(0)->hourScale()->start()->value());
        $this->assertEquals(16, $subtract->periods()->offsetGet(0)->hourScale()->end()->value());
        $this->assertEquals(17, $subtract->periods()->offsetGet(1)->hourScale()->start()->value());
        $this->assertEquals(20, $subtract->periods()->offsetGet(1)->hourScale()->end()->value());
    }

    /**
     * [              ]
     * [          ]
     */
    public function testSubtract2()
    {
        $timePeriod1 = new Period(
            Time::builder()->today(15, 0, 0),
            Time::builder()->today(20, 0, 0)
        );

        $timePeriod2 = new Period(
            Time::builder()->today(15, 0, 0),
            Time::builder()->today(17, 0, 0)
        );
        $calculator = new Calculator();
        $subtract = $calculator->subtract($timePeriod1, $timePeriod2);
        $this->assertFalse($subtract->periods()->isEmpty());
        $this->assertEquals(1, $subtract->periods()->count());
        $this->assertEquals(17, $subtract->periods()->offsetGet(0)->hourScale()->start()->value());
        $this->assertEquals(20, $subtract->periods()->offsetGet(0)->hourScale()->end()->value());


    }

    /**
     * [              ]
     *     [          ]
     */
    public function testSubtract3()
    {
        $timePeriod1 = new Period(
            Time::builder()->today(15, 0, 0),
            Time::builder()->today(20, 0, 0)
        );

        $timePeriod2 = new Period(
            Time::builder()->today(16, 0, 0),
            Time::builder()->today(20, 0, 0)
        );
        $calculator = new Calculator();
        $subtract = $calculator->subtract($timePeriod1, $timePeriod2);
        $this->assertFalse($subtract->periods()->isEmpty());
        $this->assertEquals(1, $subtract->periods()->count());
        $this->assertEquals(15, $subtract->periods()->offsetGet(0)->hourScale()->start()->value());
        $this->assertEquals(16, $subtract->periods()->offsetGet(0)->hourScale()->end()->value());
    }

    /**
     * [              ]
     * [              ]
     */
    public function testSubtract4()
    {
        $timePeriod1 = new Period(
            Time::builder()->today(15, 0, 0),
            Time::builder()->today(20, 0, 0)
        );

        $timePeriod2 = new Period(
            Time::builder()->today(15, 0, 0),
            Time::builder()->today(20, 0, 0)
        );
        $calculator = new Calculator();
        $subtract = $calculator->subtract($timePeriod1, $timePeriod2);
        $this->assertTrue($subtract->periods()->isEmpty());
    }

    /**
     *     [          ]
     * [              ]
     */
    public function testSubtract5()
    {
        $timePeriod1 = new Period(
            Time::builder()->today(15, 0, 0),
            Time::builder()->today(20, 0, 0)
        );

        $timePeriod2 = new Period(
            Time::builder()->today(13, 0, 0),
            Time::builder()->today(20, 0, 0)
        );
        $calculator = new Calculator();
        $subtract = $calculator->subtract($timePeriod1, $timePeriod2);
        $this->assertFalse($subtract->periods()->isEmpty());
        $this->assertEquals(1, $subtract->periods()->count());
        $this->assertEquals(13, $subtract->periods()->offsetGet(0)->hourScale()->start()->value());
        $this->assertEquals(15, $subtract->periods()->offsetGet(0)->hourScale()->end()->value());
    }

    /**
     *     [      ]
     * [              ]
     */
    public function testSubtract6()
    {
        $timePeriod1 = new Period(
            Time::builder()->today(15, 0, 0),
            Time::builder()->today(17, 0, 0)
        );

        $timePeriod2 = new Period(
            Time::builder()->today(13, 0, 0),
            Time::builder()->today(21, 0, 0)
        );
        $calculator = new Calculator();
        $subtract = $calculator->subtract($timePeriod1, $timePeriod2);
        $this->assertFalse($subtract->periods()->isEmpty());
        $this->assertEquals(2, $subtract->periods()->count());
        $this->assertEquals(13, $subtract->periods()->offsetGet(0)->hourScale()->start()->value());
        $this->assertEquals(15, $subtract->periods()->offsetGet(0)->hourScale()->end()->value());
        $this->assertEquals(17, $subtract->periods()->offsetGet(1)->hourScale()->start()->value());
        $this->assertEquals(21, $subtract->periods()->offsetGet(1)->hourScale()->end()->value());
    }

    /**
     * [          ]
     * [              ]
     */
    public function testSubtract7()
    {
        $timePeriod1 = new Period(
            Time::builder()->today(15, 0, 0),
            Time::builder()->today(20, 0, 0)
        );

        $timePeriod2 = new Period(
            Time::builder()->today(15, 0, 0),
            Time::builder()->today(21, 0, 0)
        );

        $calculator = new Calculator();
        $subtract = $calculator->subtract($timePeriod1, $timePeriod2);
        $this->assertFalse($subtract->periods()->isEmpty());
        $this->assertEquals(1, $subtract->periods()->count());
        $this->assertEquals(20, $subtract->periods()->offsetGet(0)->hourScale()->start()->value());
        $this->assertEquals(21, $subtract->periods()->offsetGet(0)->hourScale()->end()->value());
    }

    /**
     *    [               ]
     * [              ]
     */
    public function testSubtract8()
    {
        $timePeriod1 = new Period(
            Time::builder()->today(15, 0, 0),
            Time::builder()->today(21, 0, 0)
        );

        $timePeriod2 = new Period(
            Time::builder()->today(13, 0, 0),
            Time::builder()->today(17, 0, 0)
        );
        $calculator = new Calculator();
        $subtract = $calculator->subtract($timePeriod1, $timePeriod2);
        $this->assertFalse($subtract->periods()->isEmpty());
        $this->assertEquals(2, $subtract->periods()->count());
        $this->assertEquals(13, $subtract->periods()->offsetGet(0)->hourScale()->start()->value());
        $this->assertEquals(15, $subtract->periods()->offsetGet(0)->hourScale()->end()->value());
        $this->assertEquals(17, $subtract->periods()->offsetGet(1)->hourScale()->start()->value());
        $this->assertEquals(21, $subtract->periods()->offsetGet(1)->hourScale()->end()->value());
    }


    /**
     * [               ]
     *     [              ]
     */
    public function testSubtract9()
    {
        $timePeriod1 = new Period(
            Time::builder()->today(15, 0, 0),
            Time::builder()->today(20, 0, 0)
        );

        $timePeriod2 = new Period(
            Time::builder()->today(16, 0, 0),
            Time::builder()->today(21, 0, 0)
        );
        $calculator = new Calculator();
        $subtract = $calculator->subtract($timePeriod1, $timePeriod2);
        $this->assertFalse($subtract->periods()->isEmpty());
        $this->assertEquals(2, $subtract->periods()->count());
        $this->assertEquals(15, $subtract->periods()->offsetGet(0)->hourScale()->start()->value());
        $this->assertEquals(16, $subtract->periods()->offsetGet(0)->hourScale()->end()->value());
        $this->assertEquals(20, $subtract->periods()->offsetGet(1)->hourScale()->start()->value());
        $this->assertEquals(21, $subtract->periods()->offsetGet(1)->hourScale()->end()->value());
    }

    /**
     * [               ]
     *                        [              ]
     */
    public function testSubtract10()
    {
        $timePeriod1 = new Period(
            Time::builder()->today(15, 0, 0),
            Time::builder()->today(20, 0, 0)
        );

        $timePeriod2 = new Period(
            Time::builder()->today(21, 0, 0),
            Time::builder()->today(23, 0, 0)
        );
        $calculator = new Calculator();
        $subtract = $calculator->subtract($timePeriod1, $timePeriod2);
        $this->assertTrue($subtract->periods()->isEmpty());
    }


    /**
     *                      [               ]
     * [              ]
     */
    public function testSubtract11()
    {
        $timePeriod1 = new Period(
            Time::builder()->today(21, 0, 0),
            Time::builder()->today(23, 0, 0)
        );

        $timePeriod2 = new Period(
            Time::builder()->today(15, 0, 0),
            Time::builder()->today(16, 0, 0)
        );
        $calculator = new Calculator();
        $subtract = $calculator->subtract($timePeriod1, $timePeriod2);
        $this->assertTrue($subtract->periods()->isEmpty());
    }
}