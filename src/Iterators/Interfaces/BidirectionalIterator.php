<?php

declare(strict_types=1);

namespace IterTools\Iterators\Interfaces;

/**
 * @template TKey
 * @template TValue
 *
 * @extends \Iterator<TKey, TValue>
 */
interface BidirectionalIterator extends \Iterator
{
    /**
     * @return TValue|false
     */
    public function current();

    /**
     * @return TKey|null
     */
    public function key();

    /**
     * @return void
     */
    public function next(): void;

    /**
     * @return void
     */
    public function prev(): void;

    /**
     * @return bool
     */
    public function valid(): bool;

    /**
     * @return void
     */
    public function rewind(): void;

    /**
     * @return void
     */
    public function end(): void;
}
