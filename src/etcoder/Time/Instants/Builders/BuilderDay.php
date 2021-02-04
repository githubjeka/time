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

namespace etcoder\Time\Instants\Builders;

use etcoder\Time\Instants\Day;
use etcoder\Time\Instants\Month;
use etcoder\Time\Instants\Year;

final class BuilderDay
{
    /**
     * Returns Day by string format iso8601
     * https://en.wikipedia.org/wiki/ISO_8601
     * "YYYY-MM-DD" in the extended format or "YYYYMMDD" in the basic format.
     */
    public function byString(string $iso8601): Day
    {
        return $this->stringToDay($iso8601);
    }

    private function stringToDay(string $string): Day
    {
        try {
            $dateTime = new \DateTimeImmutable($string);
        } catch (\Exception $exception) {
            throw new \InvalidArgumentException($exception->getMessage());
        }

        if ($dateTime === false) {
            throw new \InvalidArgumentException("$string is wrong");
        }

        return $this->byDatetime($dateTime);
    }

    /**
     * Returns Day by PHP DateTime object
     */
    public function byDatetime(\DateTimeInterface $dateTime): Day
    {
        $year = new Year((int)$dateTime->format('Y'));
        $month = new Month($year, (int)$dateTime->format('n'));
        $dayOfMonth = $dateTime->format('d');

        return new Day($month, (int)$dayOfMonth);
    }

    /**
     * Returns current Day
     */
    public function now(): Day
    {
        return $this->byDatetime(new \DateTimeImmutable());
    }

    public function dayOfMonth(Month $month, int $numberDay): Day
    {
       return $this->byIntParams($month->year()->number(), $month->number(), $numberDay);
    }

    /**
     * Returns Day according to integers values of number year, month and day
     */
    public function byIntParams(int $year, int $month, int $day): Day
    {
        if ($year <= 99) {
            $format = 'y-n-j';
        } else {
            $format = 'Y-n-j';
        }
        $dateTime = \DateTimeImmutable::createFromFormat($format, "$year-$month-$day");
        return $this->byDatetime($dateTime);
    }
}