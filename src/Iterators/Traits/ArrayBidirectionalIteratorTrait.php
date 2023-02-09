<?php

declare(strict_types=1);

namespace IterTools\Iterators\Traits;

use IterTools\Iterators\ArrayBidirectionalForwardIterator;
use IterTools\Iterators\ArrayBidirectionalReverseIterator;
use IterTools\Iterators\Interfaces\BidirectionalArrayAccessIterator;

/**
 * Trait for bidirectional array iterators.
 *
 * @see ArrayBidirectionalForwardIterator
 * @see ArrayBidirectionalReverseIterator
 *
 * @template TKey
 * @template TValue
 *
 * @implements BidirectionalArrayAccessIterator<TKey, TValue>
 *
 * @property array<TKey, TValue> $data
 */
trait ArrayBidirectionalIteratorTrait
{
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
     * @return TKey|null
     */
    public function key()
    {
        return key($this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function valid(): bool
    {
        return $this->key() !== null;
    }
}
