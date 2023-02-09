<?php

declare(strict_types=1);

namespace IterTools\Iterators\Interfaces;

/**
 * Interface to create an external BidirectionalIterator.
 *
 * @see BidirectionalIterator
 *
 * @template TKey
 * @template TValue
 *
 * @extends \IteratorAggregate<TKey, TValue>
 */
interface BidirectionalIteratorAggregate extends \IteratorAggregate
{
    /**
     * Retrieve an external iterator.
     *
     * @return BidirectionalIterator<TKey, TValue>
     */
    public function getIterator(): BidirectionalIterator;
}
