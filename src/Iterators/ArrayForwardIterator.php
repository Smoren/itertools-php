<?php

namespace IterTools\Iterators;

use IterTools\Iterators\Interfaces\BidirectionalIterator;
use IterTools\Iterators\Interfaces\ReversibleIterator;

/**
 * @template TKey
 * @template TValue
 *
 * @phpstan-type TArrayKey = (int&TKey)|(string&TKey)
 *
 * @implements BidirectionalIterator<TArrayKey, TValue>
 * @implements ReversibleIterator<TArrayKey, TValue>
 */
class ArrayForwardIterator implements BidirectionalIterator, ReversibleIterator
{
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
    public function current()
    {
        return current($this->data);
    }

    /**
     * {@inheritDoc}
     *
     * @return TArrayKey|null
     */
    public function key()
    {
        return key($this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function next(): void
    {
        next($this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function prev(): void
    {
        prev($this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function valid(): bool
    {
        return $this->key() !== null;
    }

    /**
     * {@inheritDoc}
     */
    public function rewind(): void
    {
        reset($this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function end(): void
    {
        end($this->data);
    }

    /**
     * {@inheritDoc}
     *
     * @return ArrayReverseIterator<TArrayKey, TValue>
     */
    public function reverse(): ArrayReverseIterator
    {
        return new ArrayReverseIterator($this->data);
    }
}
