<?php

namespace IterTools\Iterators;

/**
 * @template TValue
 * @phpstan-type TKey = int|string
 *
 * @implements ReversibleIterator<TKey, TValue>
 * @extends \ArrayIterator<TKey, TValue>
 */
class ArrayDirectIterator extends \ArrayIterator implements ReversibleIterator
{
    /**
     * @var array<TKey, TValue>
     */
    protected array $data;

    /**
     * @param array<TKey, TValue> $array
     */
    public function __construct($array = [])
    {
        parent::__construct($array);
        $this->data = $array;
    }

    /**
     * @return ArrayReverseIterator<TValue>
     */
    public function reverse(): ArrayReverseIterator
    {
        return new ArrayReverseIterator($this->data);
    }
}
