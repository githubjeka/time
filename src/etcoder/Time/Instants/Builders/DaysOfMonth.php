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

    use etcoder\Time\Instants\Day;
    use etcoder\Time\Instants\Month;

    function firstDayOfMonth(Month $month): Day
    {
        return Day::builder()
            ->byDatetime(
                \DateTimeImmutable::createFromFormat(
                    'Y-n-d',
                    $month->year()->number() . '-' . $month->number() . '-01'
                )
            );
    }

    function lastDayOfMonth(Month $month): Day
    {
        return new Day($month, $month->numberOfDays());
    }
}