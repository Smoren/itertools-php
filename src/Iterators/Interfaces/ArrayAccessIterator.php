<?php

namespace IterTools\Iterators\Interfaces;

/**
 * @template TKey
 * @template TValue
 *
 * @extends BidirectionalIterator<TKey, TValue>
 * @extends ReversibleIterator<TKey, TValue>
 * @extends \ArrayAccess<TKey, TValue>
 */
interface ArrayAccessIterator extends BidirectionalIterator, ReversibleIterator, \ArrayAccess
{
}
