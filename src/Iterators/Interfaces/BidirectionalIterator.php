<?php

declare(strict_types=1);

namespace IterTools\Iterators\Interfaces;

/**
 * Bidirectional read iterator.
 *
 * @template TKey
 * @template TValue
 *
 * @extends \Iterator<TKey, TValue>
 */
interface BidirectionalIterator extends \Iterator
{
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
     * Move forward to previous element.
     *
     * @return void
     */
    public function prev(): void;

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

    /**
     * Rewind the Iterator to the last element.
     *
     * @return void
     */
    public function last(): void;
}
