<?php

declare(strict_types=1);

namespace IterTools\Iterators;

use IterTools\Iterators\Interfaces\ArrayAccessList;
use IterTools\Iterators\Interfaces\BidirectionalIterator;
use IterTools\Iterators\Interfaces\ReversibleIterator;
use IterTools\Iterators\Traits\ListBidirectionalIteratorTrait;

/**
 * Read array list bidirectional iterator (reverse in foreach loop).
 *
 * @template T
 *
 * @implements BidirectionalIterator<int, T>
 * @implements ReversibleIterator<int, T>
 */
class ListBidirectionalReverseIterator implements BidirectionalIterator, ReversibleIterator, \Countable
{
    /**
     * @use ListBidirectionalIteratorTrait<T>
     */
    use ListBidirectionalIteratorTrait;

    /**
     * @var list<T>|ArrayAccessList<T>
     */
    protected $data;
    /**
     * @var int
     */
    protected int $index;

    /**
     * @param list<T>|ArrayAccessList<T> $data
     */
    public function __construct(&$data)
    {
        $this->data = &$data;
        $this->index = 0;
    }

    /**
     * {@inheritDoc}
     */
    public function next(): void
    {
        if ($this->valid()) {
            $this->index--;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function prev(): void
    {
        if ($this->valid()) {
            $this->index++;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function rewind(): void
    {
        $this->index = count($this) - 1;
    }

    /**
     * {@inheritDoc}
     */
    public function end(): void
    {
        $this->index = 0;
    }

    /**
     * {@inheritDoc}
     *
     * @return ListBidirectionalForwardIterator<T>
     */
    public function reverse(): ListBidirectionalForwardIterator
    {
        return new ListBidirectionalForwardIterator($this->data);
    }
}
