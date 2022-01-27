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

namespace etcoder\Time\Instants\Formats;

use etcoder\Time\Instants\Time;

final class TimeFormatting
{
    public function __construct(private Time $time)
    {
    }

    public function toDatetime(?\DateTimeZone $timezone = null): \DateTimeImmutable
    {
        $datetime = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $this->toString(), $timezone);
        if ($datetime === false) {
            // False is not possible.
            // Please send bug report
            // print_r(DateTimeImmutable::getLastErrors());die();
            // (╯°□°）╯︵ ┻━┻
            throw new \UnexpectedValueException();
        }
        return $datetime;
    }

    /**
     * String "YYYY-MM-DD hh:mm:s" in the extended format
     * https://en.wikipedia.org/wiki/ISO_8601
     */
    public function toString(): string
    {
        if ($this->time->hour() === 24) {
            return $this->time->day()->next()->format()->toExtended() . ' 00:00:00';
        }

        $hour = sprintf('%02d', $this->time->hour());
        $minute = sprintf('%02d', $this->time->minute());
        $second = sprintf('%02d', $this->time->second());

        return $this->time->day()->format()->toExtended() . " $hour:$minute:$second";
    }
}