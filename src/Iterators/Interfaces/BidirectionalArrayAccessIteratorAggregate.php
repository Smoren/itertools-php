<?php

declare(strict_types=1);

namespace IterTools\Iterators\Interfaces;

/**
 * Interface to create an external ArrayAccessIterator.
 *
 * @see BidirectionalArrayAccessIterator
 *
 * @template TKey
 * @template TValue
 *
 * @extends \IteratorAggregate<TKey, TValue>
 */
interface BidirectionalArrayAccessIteratorAggregate extends \IteratorAggregate
{
    /**
     * Retrieve an external iterator.
     *
     * @return BidirectionalArrayAccessIterator<TKey, TValue>
     */
    public function getIterator(): BidirectionalArrayAccessIterator;
}
