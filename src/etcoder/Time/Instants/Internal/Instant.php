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

namespace etcoder\Time\Instants\Internal;

use etcoder\Time\Instants\Interfaces\ComparisonResult;
use etcoder\Time\Instants\Interfaces\Instant as InstantInterface;

abstract class Instant implements InstantInterface
{
    use Iterator;

    public function compareTo(InstantInterface $instant): ComparisonResult
    {
        $this->checkTypeInstant($instant);

        return $this->comparisonResult($instant);
    }

    protected function getInstant(): InstantInterface
    {
        return $this;
    }

    protected function checkTypeInstant(InstantInterface $otherInstant)
    {
        $class = get_class($this);
        if (!($otherInstant instanceof $class)) {
            throw new \InvalidArgumentException(get_class($otherInstant));
        }
    }

    abstract protected function comparisonResult(InstantInterface $instant): ComparisonResult;
}