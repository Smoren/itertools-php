<?php

declare(strict_types=1);

namespace IterTools\Iterators\Interfaces;

/**
 * Interface to create an external ReversibleIterator.
 *
 * @see ReversibleIterator
 *
 * @template TKey
 * @template TValue
 *
 * @extends \IteratorAggregate<TKey, TValue>
 */
interface ReversibleIteratorAggregate extends \IteratorAggregate
{
    /**
     * Retrieve an external iterator.
     *
     * @return ReversibleIterator<TKey, TValue>
     */
    public function getIterator(): ReversibleIterator;
}
