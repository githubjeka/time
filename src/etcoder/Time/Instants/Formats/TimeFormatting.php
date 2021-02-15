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


use DateTimeImmutable;
use etcoder\Time\Instants\Time;

final class TimeFormatting
{
    private $time;

    public function __construct(Time $time)
    {
        $this->time = $time;
    }

    public function toDatetime(): DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat('Y-m-d H:m:i', $this->toString());
    }

    /**
     * String "YYYY-MM-DD hh:mm:s" in the extended format
     * https://en.wikipedia.org/wiki/ISO_8601
     */
    public function toString(): string
    {
        $hour = sprintf('%02d', $this->time->hour());
        $minute = sprintf('%02d', $this->time->minute());
        $second = sprintf('%02d', $this->time->second());

        return $this->time->day()->format()->toExtended() . " $hour:$minute:$second";
    }
}