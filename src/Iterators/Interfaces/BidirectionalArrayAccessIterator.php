<?php

declare(strict_types=1);

namespace IterTools\Iterators\Interfaces;

/**
 * Read/write iterator for bidirectional iterable & ArrayAccess collections.
 *
 * Allows bidirectional iterating of arrays and collections which are simultaneously iterable and ArrayAccess instances.
 *
 * Allows accessing the collection items for reading and writing using [] operator.
 *
 * Allows reverting the iterator.
 *
 * @template TKey
 * @template TValue
 *
 * @extends BidirectionalIterator<TKey, TValue>
 * @extends ReversibleIterator<TKey, TValue>
 * @extends \ArrayAccess<TKey, TValue>
 */
interface BidirectionalArrayAccessIterator extends BidirectionalIterator, ReversibleIterator, \ArrayAccess
{
}
