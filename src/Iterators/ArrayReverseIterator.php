<?php

declare(strict_types=1);

namespace IterTools\Iterators;

use IterTools\Iterators\Interfaces\BidirectionalIterator;
use IterTools\Iterators\Interfaces\ReversibleIterator;
use IterTools\Iterators\Traits\ArrayIteratorTrait;

/**
 * @template TKey
 * @template TValue
 *
 * @phpstan-type TArrayKey = (int&TKey)|(string&TKey)
 *
 * @implements BidirectionalIterator<TArrayKey, TValue>
 * @implements ReversibleIterator<TArrayKey, TValue>
 */
class ArrayReverseIterator implements BidirectionalIterator, ReversibleIterator
{
    /**
     * @use ArrayIteratorTrait<TKey, TValue>
     */
    use ArrayIteratorTrait;

    /**
     * @var array<TArrayKey, TValue>
     */
    protected array $data;

    /**
     * @param array<TArrayKey, TValue> $data
     */
    public function __construct(array &$data)
    {
        $this->data = &$data;
    }

    /**
     * {@inheritDoc}
     */
    public function next(): void
    {
        prev($this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function prev(): void
    {
        next($this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function rewind(): void
    {
        end($this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function end(): void
    {
        reset($this->data);
    }

    /**
     * {@inheritDoc}
     *
     * @return ArrayForwardIterator<TArrayKey, TValue>
     */
    public function reverse(): ArrayForwardIterator
    {
        return new ArrayForwardIterator($this->data);
    }
}
