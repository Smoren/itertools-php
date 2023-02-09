<?php

declare(strict_types=1);

namespace IterTools\Iterators\Interfaces;

/**
 * Read/write random access iterator.
 *
 * Allows bidirectional iterating with jumping an arbitrary number of steps at a time.
 *
 * Allows accessing the collection items for reading and writing using [] operator.
 *
 * Allows reverting the iterator.
 *
 * @template TKey
 * @template TValue
 *
 * @extends BidirectionalArrayAccessIterator<TKey, TValue>
 */
interface RandomAccessIterator extends BidirectionalArrayAccessIterator
{
    /**
     * Moves forward by the given number of steps.
     *
     * @param int $steps
     *
     * @return void
     */
    public function movePointer(int $steps): void;
}
