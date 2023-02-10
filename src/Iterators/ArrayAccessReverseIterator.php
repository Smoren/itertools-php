<?php

declare(strict_types=1);

namespace IterTools\Iterators;

use IterTools\Iterators\Interfaces\BidirectionalArrayAccessIteratorAggregate;
use IterTools\Iterators\Interfaces\BidirectionalArrayAccessIterator;
use IterTools\Iterators\Traits\ArrayAccessIteratorTrait;

/**
 * Read/write iterator for bidirectional iterable & ArrayAccess collections (reverse in foreach loop).
 *
 * @template TKey
 * @template TValue
 *
 * @implements BidirectionalArrayAccessIterator<TKey, TValue>
 */
class ArrayAccessReverseIterator implements BidirectionalArrayAccessIterator
{
    /**
     * @use ArrayAccessIteratorTrait<TKey, TValue>
     */
    use ArrayAccessIteratorTrait;

    /**
     * @var BidirectionalArrayAccessIterator<TKey, TValue>
     */
    protected $data;

    /**
     * @param BidirectionalArrayAccessIterator<TKey, TValue>|BidirectionalArrayAccessIteratorAggregate<TKey, TValue> $input
     */
    public function __construct(&$input)
    {
        if ($input instanceof BidirectionalArrayAccessIteratorAggregate) {
            /** @var BidirectionalArrayAccessIterator<TKey, TValue> $iterator */
            $iterator = $input->getIterator();
            $this->data = $iterator;
        } else {
            $this->data = $input;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function next(): void
    {
        $this->data->prev();
    }

    /**
     * {@inheritDoc}
     */
    public function prev(): void
    {
        $this->data->next();
    }

    /**
     * {@inheritDoc}
     */
    public function rewind(): void
    {
        $this->data->end();
    }

    /**
     * {@inheritDoc}
     */
    public function end(): void
    {
        $this->data->rewind();
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
