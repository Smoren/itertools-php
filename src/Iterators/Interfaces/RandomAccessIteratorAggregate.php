<?php

declare(strict_types=1);

namespace IterTools\Iterators\Interfaces;

/**
 * Interface to create an external RandomAccessIterator.
 *
 * @see RandomAccessIterator
 *
 * @template TKey
 * @template TValue
 *
 * @extends \IteratorAggregate<TKey, TValue>
 */
interface RandomAccessIteratorAggregate extends \IteratorAggregate
{
    /**
     * Retrieve an external iterator.
     *
     * @return RandomAccessIterator <TKey, TValue>
     */
    public function getIterator(): RandomAccessIterator;
}
