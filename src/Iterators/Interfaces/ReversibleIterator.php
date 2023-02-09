<?php

declare(strict_types=1);

namespace IterTools\Iterators\Interfaces;

/**
 * Iterator which can create a new reversed iterator of its collection.
 *
 * @template TKey
 * @template TValue
 *
 * @extends \Iterator<TKey, TValue>
 */
interface ReversibleIterator extends \Iterator
{
    /**
     * Creates new iterator which is reversed of this one.
     *
     * @return \Iterator<TKey, TValue>
     */
    public function reverse(): \Iterator;

    /**
     * {@inheritDoc}
     *
     * @return TValue|false
     */
    public function current();

    /**
     * {@inheritDoc}
     *
     * @return TKey|null
     */
    public function key();

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    public function next(): void;

    /**
     * {@inheritDoc}
     *
     * @return bool
     */
    public function valid(): bool;

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    public function rewind(): void;
}
