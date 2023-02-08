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

    /**
     * @return TValue|false
     */
    public function current();

    /**
     * @return void
     */
    public function next(): void;

    /**
     * @return TKey|null
     */
    public function key();

    /**
     * @return bool
     */
    public function valid(): bool;

    /**
     * @return void
     */
    public function rewind(): void;
}
