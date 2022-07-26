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

namespace etcoder\Time\Iterators;

use etcoder\Time\Instants\Day;
use etcoder\Time\Instants\Internal\Instant;
use etcoder\Time\Instants\Iterators\IteratorInstant;
use etcoder\Time\Instants\Month;
use etcoder\Time\Instants\Year;
use PHPUnit\Framework\TestCase;

class IteratorInstantTest extends TestCase
{
    /**
     * @dataProvider additionProvider
     * @param Instant[] $instantsArray
     */
    public function testInstants(array $instantsArray)
    {
        $start = $instantsArray[0];
        $last = $instantsArray[7];
        $i = 0;

        $iterator = new IteratorInstant();

        $this->assertCount(count($instantsArray), $iterator->array($start, $last));

        $list = $iterator->list($start, $last);
        foreach ($list as $next) {
            $this->assertTrue($next->compareTo($instantsArray[$i])->isEqual(), "error on $i");
            $i++;
        }

        $start = $instantsArray[7];
        $last = $instantsArray[0];
        $i = 7;

        $this->assertCount(count($instantsArray), $iterator->array($start, $last));

        $list = $iterator->list($start, $last);
        foreach ($list as $prev) {
            $this->assertTrue($prev->compareTo($instantsArray[$i])->isEqual(), "error on $i");
            $i--;
        }

        $start = $last = $instantsArray[0];
        $this->assertCount(1, $iterator->array($start, $last));

        $list = $iterator->list($start, $last);
        foreach ($list as $next) {
            $this->assertTrue($next->compareTo($instantsArray[0])->isEqual(), "error on $i");
        }

        $start = $instantsArray[0];
        $last = $instantsArray[7];
        $i = 0;
        $step = 3;

        $this->assertCount(count($instantsArray) % $step + 1, $iterator->array($start, $last, $step));

        $list = $iterator->list($start, $last, $step);
        foreach ($list as $next) {
            $this->assertTrue($next->compareTo($instantsArray[$i])->isEqual(), "error on $i");
            $i = $i + $step;
        }
    }

    /**
     * @dataProvider additionProvider
     * @param Instant[] $instantsArray
     */
    public function testDay(array $instantsArray)
    {
        $start = $instantsArray[0];
        $last = $instantsArray[7];
        $i = 0;

        $this->assertCount(count($instantsArray), $start->arrayTo($last));

        foreach ($start->iteratorTo($last) as $next) {
            $this->assertTrue($next->compareTo($instantsArray[$i])->isEqual(), "error on $i");
            $i++;
        }
    }

    public function additionProvider(): array
    {
        return [
            'days' => [
                [
                    Day::builder()->byIntParams(2000, 1, 1),
                    Day::builder()->byIntParams(2000, 1, 2),
                    Day::builder()->byIntParams(2000, 1, 3),
                    Day::builder()->byIntParams(2000, 1, 4),
                    Day::builder()->byIntParams(2000, 1, 5),
                    Day::builder()->byIntParams(2000, 1, 6),
                    Day::builder()->byIntParams(2000, 1, 7),
                    Day::builder()->byIntParams(2000, 1, 8),
                ],
            ],
            'months' => [
                [
                    Month::builder()->byIntParams(2000, 11),
                    Month::builder()->byIntParams(2000, 12),
                    Month::builder()->byIntParams(2001, 1),
                    Month::builder()->byIntParams(2001, 2),
                    Month::builder()->byIntParams(2001, 3),
                    Month::builder()->byIntParams(2001, 4),
                    Month::builder()->byIntParams(2001, 5),
                    Month::builder()->byIntParams(2001, 6),
                ],
            ],
            'years' => [
                [
                    Year::builder()->byInt(1999),
                    Year::builder()->byInt(2000),
                    Year::builder()->byInt(2001),
                    Year::builder()->byInt(2002),
                    Year::builder()->byInt(2003),
                    Year::builder()->byInt(2004),
                    Year::builder()->byInt(2005),
                    Year::builder()->byInt(2006),
                ],
            ],
        ];
    }

}