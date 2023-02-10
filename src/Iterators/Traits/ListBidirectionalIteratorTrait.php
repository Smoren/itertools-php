<?php

namespace IterTools\Iterators\Traits;

use IterTools\Iterators\Interfaces\ArrayAccessList;
use IterTools\Iterators\Interfaces\BidirectionalIterator;
use IterTools\Iterators\ListBidirectionalForwardIterator;

/**
 * Trait for bidirectional array list iterators.
 *
 * @see ListBidirectionalForwardIterator
 * @see ListBidirectionalReverseIterator
 *
 * @template T
 *
 * @implements BidirectionalIterator<int, T>
 *
 * @property list<T>|ArrayAccessList<T> $data
 * @property int $index
 */
trait ListBidirectionalIteratorTrait
{
    /**
     * {@inheritDoc}
     *
     * @return T
     */
    public function current()
    {
        return $this->data[$this->index];
    }

    /**
     * {@inheritDoc}
     *
     * @return int
     */
    public function key(): int
    {
        return $this->index;
    }

    /**
     * {@inheritDoc}
     */
    public function valid(): bool
    {
        return $this->index >= 0 && $this->index < count($this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function count(): int
    {
        return count($this->data);
    }
}
