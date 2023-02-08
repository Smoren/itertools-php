<?php

namespace IterTools\Iterators;

/**
 * @template TKey
 * @template TValue
 *
 * @extends \Iterator<TKey, TValue>
 */
interface ReversibleIterator extends \Iterator
{
    /**
     * @return \Iterator<TKey, TValue>
     */
    public function reverse(): \Iterator;
}
