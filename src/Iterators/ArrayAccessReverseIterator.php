<?php

declare(strict_types=1);

namespace IterTools\Iterators;

use IterTools\Iterators\Interfaces\BidirectionalIterator;
use IterTools\Iterators\Interfaces\ArrayAccessIterator;
use IterTools\Iterators\Traits\ArrayAccessIteratorTrait;

/**
 * @template TKey
 * @template TValue
 *
 * @phpstan-type TArrayKey = (int&TKey)|(string&TKey)
 * @phpstan-type ArrayLike = array<TArrayKey, TValue>|(\ArrayAccess<TKey, TValue>&BidirectionalIterator<TKey, TValue>)
 *
 * @implements ArrayAccessIterator<TKey, TValue>
 */
class ArrayAccessReverseIterator implements ArrayAccessIterator
{
    /**
     * @use ArrayAccessIteratorTrait<TKey, TValue>
     */
    use ArrayAccessIteratorTrait;

    /**
     * @var ArrayLike
     */
    protected $data;

    /**
     * @param ArrayLike $input
     */
    public function __construct(&$input)
    {
        $this->data = &$input;
    }

    /**
     * {@inheritDoc}
     */
    public function next(): void
    {
        if ($this->data instanceof BidirectionalIterator) {
            $this->data->prev();
        } else {
            prev($this->data);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function prev(): void
    {
        if ($this->data instanceof BidirectionalIterator) {
            $this->data->next();
        } else {
            next($this->data);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function rewind(): void
    {
        if ($this->data instanceof BidirectionalIterator) {
            $this->data->end();
        } else {
            end($this->data);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function end(): void
    {
        if ($this->data instanceof BidirectionalIterator) {
            $this->data->rewind();
        } else {
            reset($this->data);
        }
    }

    /**
     * {@inheritDoc}
     *
     * @return ArrayAccessForwardIterator<TKey, TValue>
     */
    public function reverse(): ArrayAccessForwardIterator
    {
        return new ArrayAccessForwardIterator($this->data);
    }
}
