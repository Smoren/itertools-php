<?php

namespace IterTools\Iterators;

/**
 * @template TKey
 * @template TValue
 * @phpstan-type ArrayAccessible = array<TKey, TValue>|(\ArrayAccess<TKey, TValue>&iterable<TKey, TValue>)
 *
 * @implements ReversibleIterator<TKey, TValue>
 */
class ArrayAccessibleDirectIterator implements ReversibleIterator
{
    // TODO rnadom access
    /**
     * @var ArrayAccessible
     */
    protected $data;

    /**
     * @param ArrayAccessible $input
     */
    public function __construct($input)
    {
        $this->data = $input;
    }

    /**
     * @return TValue|false
     */
    public function current()
    {
        return current($this->data);
    }

    /**
     * @return void
     */
    public function next(): void
    {
        next($this->data);
    }

    /**
     * @return TKey|null
     */
    public function key()
    {
        return key($this->data);
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return key($this->data) !== null;
    }

    /**
     * @return void
     */
    public function rewind(): void
    {
        reset($this->data);
    }

    /**
     * @return ArrayAccessibleReverseIterator<TKey, TValue>
     */
    public function reverse(): ArrayAccessibleReverseIterator
    {
        return new ArrayAccessibleReverseIterator($this->data);
    }
}
