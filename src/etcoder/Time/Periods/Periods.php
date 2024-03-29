<?php

declare(strict_types=1);

namespace etcoder\Time\Periods;


class Periods implements \Countable, \IteratorAggregate, \ArrayAccess
{
    /**
     * @var Period[]
     */
    private array $periods;

    public function __construct(Period  ...$periods)
    {
        $this->periods = $periods;
    }

    public function count(): int
    {
        return count($this->periods);
    }

    /**
     * @return \ArrayIterator|Period[]
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->periods);
    }

    public function offsetExists($offset): bool
    {
        return isset($this->periods[$offset]);
    }

    public function offsetGet($offset): Period
    {
        return $this->periods[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        throw new \LogicException();
    }

    public function offsetUnset($offset): void
    {
        throw new \LogicException();
    }

    /**
     * @return Period[]
     */
    public function toArray(): array
    {
        return $this->getIterator()->getArrayCopy();
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }
}