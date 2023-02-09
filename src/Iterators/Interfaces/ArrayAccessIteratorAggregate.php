<?php

namespace IterTools\Iterators\Interfaces;

/**
 * @template TKey
 * @template TValue
 *
 * @extends \IteratorAggregate<TKey, TValue>
 */
interface ArrayAccessIteratorAggregate extends \IteratorAggregate
{
    /**
     * @return ArrayAccessIterator<TKey, TValue>
     */
    public function getIterator(): ArrayAccessIterator;
}
