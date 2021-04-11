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

    use etcoder\Time\Instants\Month;

    function January(int $year): Month
    {
        return Month::builder()->byIntParams($year, 1);
    }

    function February(int $year): Month
    {
        return Month::builder()->byIntParams($year, 2);
    }

    function March(int $year): Month
    {
        return Month::builder()->byIntParams($year, 3);
    }

    function April(int $year): Month
    {
        return Month::builder()->byIntParams($year, 4);
    }

    function May(int $year): Month
    {
        return Month::builder()->byIntParams($year, 5);
    }

    function June(int $year): Month
    {
        return Month::builder()->byIntParams($year, 6);
    }

    function July(int $year): Month
    {
        return Month::builder()->byIntParams($year, 7);
    }

    function August(int $year): Month
    {
        return Month::builder()->byIntParams($year, 8);
    }

    function September(int $year): Month
    {
        return Month::builder()->byIntParams($year, 9);
    }

    function October(int $year): Month
    {
        return Month::builder()->byIntParams($year, 10);
    }

    function November(int $year): Month
    {
        return Month::builder()->byIntParams($year, 11);
    }

    function December(int $year): Month
    {
        return Month::builder()->byIntParams($year, 12);
    }
}