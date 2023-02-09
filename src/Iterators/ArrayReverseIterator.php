<?php

declare(strict_types=1);

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
class ArrayReverseIterator implements BidirectionalIterator, ReversibleIterator
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
    public function valid(): bool
    {
        return $this->key() !== null;
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
