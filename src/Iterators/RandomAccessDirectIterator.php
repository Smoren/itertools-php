<?php

namespace IterTools\Iterators;

/**
 * @template TKey
 * @template TValue
 * @phpstan-type RandomAccess = array<TKey, TValue>|(\ArrayAccess<TKey, TValue>&BidirectionalIterator<TKey, TValue>)
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
        if ($this->data instanceof BidirectionalIterator) {
            return $this->data->current();
        }
        return current($this->data);
    }

    /**
     * @return void
     */
    public function next(): void
    {
        if ($this->data instanceof BidirectionalIterator) {
            $this->data->next();
        } else {
            next($this->data);
        }
    }

    /**
     * @return void
     */
    public function prev(): void
    {
        if ($this->data instanceof BidirectionalIterator) {
            $this->data->prev();
        } else {
            prev($this->data);
        }
    }

    /**
     * @return TKey|null
     */
    public function key()
    {
        if ($this->data instanceof BidirectionalIterator) {
            return $this->data->key();
        }
        return key($this->data);
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        if ($this->data instanceof BidirectionalIterator) {
            return $this->data->valid();
        }
        return key($this->data) !== null;
    }

    /**
     * @return void
     */
    public function rewind(): void
    {
        if ($this->data instanceof BidirectionalIterator) {
            $this->data->rewind();
        } else {
            reset($this->data);
        }
    }

    public function end(): void
    {
        if ($this->data instanceof BidirectionalIterator) {
            $this->data->end();
        } else {
            end($this->data);
        }
    }

    /**
     * @return RandomAccessReverseIterator<TKey, TValue>
     */
    public function reverse(): RandomAccessReverseIterator
    {
        return new RandomAccessReverseIterator($this->data);
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
