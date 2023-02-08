<?php

namespace IterTools\Iterators;

/**
 * @template TKey
 * @template TValue
 * @phpstan-type ArrayAccessible = array<TKey, TValue>|\ArrayAccess<TKey, TValue>
 *
 * @implements ReversibleIterator<TKey, TValue>
 */
class ArrayAccessReverseIterator implements ReversibleIterator
{
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
     * @return TValue|null
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
        prev($this->data);
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
        end($this->data);
    }

    /**
     * @return ArrayAccessDirectIterator<TKey, TValue>
     */
    public function reverse(): ArrayAccessDirectIterator
    {
        return new ArrayAccessDirectIterator($this->data);
    }
}
