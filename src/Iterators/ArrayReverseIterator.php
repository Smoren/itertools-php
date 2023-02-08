<?php

namespace IterTools\Iterators;

/**
 * @template TValue
 * @phpstan-type TKey = int|string
 *
 * @implements ReversibleIterator<TKey, TValue>
 */
class ArrayReverseIterator implements ReversibleIterator
{
    /**
     * @var array<TKey, TValue>
     */
    protected array $data;

    /**
     * @param array<TKey, TValue> $array
     */
    public function __construct(array $array)
    {
        $this->data = $array;
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
     * @return ArrayDirectIterator<TValue>
     */
    public function reverse(): ArrayDirectIterator
    {
        return new ArrayDirectIterator($this->data);
    }
}
