<?php

namespace IterTools\Iterators;

/**
 * @template TKey
 * @template TValue
 * @phpstan-type RandomAccess = array<TKey, TValue>|(\ArrayAccess<TKey, TValue>&iterable<TKey, TValue>)
 *
 * @implements RandomAccessIterator<TKey, TValue>
 */
class RandomAccessDirectIterator implements RandomAccessIterator
{
    /**
     * @var RandomAccess
     */
    protected $data;

    /**
     * @param RandomAccess $input
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
     * @return void
     */
    public function prev(): void
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
        reset($this->data);
    }

    /**
     * @return RandomAccessDirectIterator<TKey, TValue>
     */
    public function reverse(): RandomAccessDirectIterator
    {
        return new RandomAccessDirectIterator($this->data);
    }

    /**
     * @param TKey $offset
     *
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        if ($this->data instanceof \ArrayAccess) {
            return $this->data->offsetExists($offset);
        }

        /** @var int|string $offset */
        return array_key_exists($offset, $this->data);
    }

    /**
     * @param TKey $offset
     *
     * @return TValue
     */
    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    /**
     * @param TKey $offset
     * @param TValue $value
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        /** @phpstan-ignore-next-line */
        $this->data[$offset] = $value;
    }

    /**
     * @param TKey $offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }
}
