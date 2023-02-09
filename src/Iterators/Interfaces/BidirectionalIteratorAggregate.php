<?php

namespace IterTools\Iterators\Interfaces;

/**
 * @template TKey
 * @template TValue
 *
 * @extends \IteratorAggregate<TKey, TValue>
 */
interface BidirectionalIteratorAggregate extends \IteratorAggregate
{
    /**
     * @return BidirectionalIterator<TKey, TValue>
     */
    public function getIterator(): BidirectionalIterator;
}
