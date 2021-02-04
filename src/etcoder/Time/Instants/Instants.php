<?php

declare(strict_types=1);

namespace etcoder\Time\Instants;


use etcoder\Time\Instants\Interfaces\Instant;

class Instants implements \Countable, \IteratorAggregate
{
    private $instants;

    public function __construct(Instant  ...$instants)
    {
        $this->instants = $instants;
    }

    public function count(): int
    {
        return count($this->instants);
    }


    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->instants);
    }
}