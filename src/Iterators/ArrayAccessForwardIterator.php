<?php

declare(strict_types=1);

namespace IterTools\Iterators;

use IterTools\Iterators\Interfaces\BidirectionalArrayAccessIteratorAggregate;
use IterTools\Iterators\Interfaces\BidirectionalArrayAccessIterator;
use IterTools\Iterators\Traits\ArrayAccessIteratorTrait;

/**
 * Read/write iterator for bidirectional iterable & ArrayAccess collections (forward in foreach loop).
 *
 * @template TKey
 * @template TValue
 *
 * @implements BidirectionalArrayAccessIterator<TKey, TValue>
 */
class ArrayAccessForwardIterator implements BidirectionalArrayAccessIterator
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
    public function __construct($input)
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
        $this->data->next();
    }

    /**
     * {@inheritDoc}
     */
    public function prev(): void
    {
        $this->data->prev();
    }

    /**
     * {@inheritDoc}
     */
    public function rewind(): void
    {
        $this->data->rewind();
    }

    /**
     * {@inheritDoc}
     */
    public function end(): void
    {
        $this->data->end();
    }

    /**
     * {@inheritDoc}
     *
     * @return ArrayAccessReverseIterator<TKey, TValue>
     */
    public function reverse(): ArrayAccessReverseIterator
    {
        return new ArrayAccessReverseIterator($this->data);
    }
}
