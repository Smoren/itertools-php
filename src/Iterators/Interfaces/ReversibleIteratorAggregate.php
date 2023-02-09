<?php

namespace IterTools\Iterators\Interfaces;

/**
 * @template TKey
 * @template TValue
 *
 * @extends \IteratorAggregate<TKey, TValue>
 */
interface ReversibleIteratorAggregate extends \IteratorAggregate
{
    /**
     * @return ReversibleIterator<TKey, TValue>
     */
    public function getIterator(): ReversibleIterator;
}
