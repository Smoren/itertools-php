<?php

namespace IterTools\Iterators;

/**
 * @template TKey
 * @template TValue
 *
 * @extends BidirectionalIterator<TKey, TValue>
 * @extends ReversibleIterator<TKey, TValue>
 * @extends \ArrayAccess<TKey, TValue>
 */
interface RandomAccessIterator extends BidirectionalIterator, ReversibleIterator, \ArrayAccess
{
}
