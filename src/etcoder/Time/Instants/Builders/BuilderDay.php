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

namespace etcoder\Time\Instants\Builders {

    use DateTimeInterface;
    use etcoder\Time\Instants\Day;
    use etcoder\Time\Instants\Month;
    use etcoder\Time\Instants\Year;

    final class BuilderDay
    {
        /**
         * Returns Day by string format iso8601
         * https://en.wikipedia.org/wiki/ISO_8601
         * "YYYY-MM-DD" in the extended format or "YYYYMMDD" in the basic format.
         * @throws \Exception
         */
        public function byString(string $iso8601): Day
        {
            return $this->stringToDay($iso8601);
        }

        /**
         * @throws \Exception
         */
        private function stringToDay(string $string): Day
        {
            $dateTime = new \DateTimeImmutable($string);
            return $this->byDatetime($dateTime);
        }

        /**
         * Returns Day by PHP DateTime object
         */
        public function byDatetime(DateTimeInterface $dateTime): Day
        {
            $year = new Year((int)$dateTime->format('Y'));
            $month = new Month($year, (int)$dateTime->format('n'));
            $dayOfMonth = $dateTime->format('d');

            return new Day($month, (int)$dayOfMonth);
        }

        /**
         * Returns the current calendar day
         */
        public function today(): Day
        {
            return $this->byDatetime(new \DateTimeImmutable());
        }

        /**
         * Returns Day by number of Month.
         * @throws \Exception
         */
        public function ofMonth(Month $month, int $numberDay): Day
        {
            return $this->byIntParams($month->year()->number(), $month->number(), $numberDay);
        }

        /**
         * Returns Day according to integers values of number year, month and day
         * @throws \Exception
         */
        public function byIntParams(int $year, int $month, int $day): Day
        {
            if ($year <= 99) {
                $format = 'y-n-j';
            } else {
                $format = 'Y-n-j';
            }
            $dateTime = \DateTimeImmutable::createFromFormat($format, "$year-$month-$day");
            if ($dateTime === false) {
                throw new \Exception('something wrong');
            }

            return $this->byDatetime($dateTime);
        }
    }

    /**
     * @see BuilderDay::today()
     */
    function today(): Day
    {
        return Day::builder()->today();
    }

    /**
     * @throws \Exception
     * @see BuilderDay::byString()
     */
    function day_by_string(string $day): Day
    {
        return Day::builder()->byString($day);
    }

    /**
     * @see BuilderDay::day_by_datetime()
     */
    function day_by_datetime(DateTimeInterface $day): Day
    {
        return Day::builder()->byDatetime($day);
    }
}