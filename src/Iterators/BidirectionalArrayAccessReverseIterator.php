<?php

declare(strict_types=1);

namespace IterTools\Iterators;

use IterTools\Iterators\Interfaces\BidirectionalIterator;
use IterTools\Iterators\Interfaces\BidirectionalArrayAccessIterator;
use IterTools\Iterators\Interfaces\BidirectionalIteratorAggregate;
use IterTools\Iterators\Traits\BidirectionalArrayAccessIteratorTrait;

/**
 * Read/write iterator for bidirectional iterable & ArrayAccess collections (reverse and foreach loop).
 *
 * @template TKey
 * @template TValue
 *
 * @phpstan-type TArrayKey = (int&TKey)|(string&TKey)
 * @phpstan-type SourceArray = array<TArrayKey, TValue>
 * @phpstan-type ArrayAccessBidIterator = \ArrayAccess<TKey, TValue>&BidirectionalIterator<TKey, TValue>
 * @phpstan-type ArrayAccessBidIterable = \ArrayAccess<TKey, TValue>&BidirectionalIteratorAggregate<TKey, TValue>
 * @phpstan-type IterableArrayAccess = SourceArray|ArrayAccessBidIterator|ArrayAccessBidIterable
 *
 * @implements BidirectionalArrayAccessIterator<TKey, TValue>
 */
class BidirectionalArrayAccessReverseIterator implements BidirectionalArrayAccessIterator
{
    /**
     * @use BidirectionalArrayAccessIteratorTrait<TKey, TValue>
     */
    use BidirectionalArrayAccessIteratorTrait;

    /**
     * @var SourceArray|ArrayAccessBidIterator
     */
    protected $data;

    /**
     * @param IterableArrayAccess $input
     */
    public function __construct(&$input)
    {
        if ($input instanceof BidirectionalIteratorAggregate) {
            /** @var ArrayAccessBidIterator<TKey, TValue> $iterator */
            $iterator = $input->getIterator();
            $this->data = $iterator;
        } else {
            $this->data = &$input;
        }
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
     * @return BidirectionalArrayAccessForwardIterator<TKey, TValue>
     */
    public function reverse(): BidirectionalArrayAccessForwardIterator
    {
        return new BidirectionalArrayAccessForwardIterator($this->data);
    }
}
