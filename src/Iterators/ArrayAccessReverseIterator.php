<?php

namespace IterTools\Iterators;

use IterTools\Iterators\Interfaces\BidirectionalIterator;
use IterTools\Iterators\Interfaces\ArrayAccessIterator;

/**
 * @template TKey
 * @template TValue
 *
 * @phpstan-type TArrayKey = (int&TKey)|(string&TKey)
 * @phpstan-type RandomAccess = array<TArrayKey, TValue>|(\ArrayAccess<TKey, TValue>&BidirectionalIterator<TKey, TValue>)
 *
 * @implements ArrayAccessIterator<TKey, TValue>
 */
class ArrayAccessReverseIterator implements ArrayAccessIterator
{
    /**
     * @var RandomAccess
     */
    protected $data;

    /**
     * @param RandomAccess $input
     */
    public function __construct(&$input)
    {
        $this->data = &$input;
    }

    /**
     * {@inheritDoc}
     */
    public function current()
    {
        if ($this->data instanceof BidirectionalIterator) {
            return $this->data->current();
        }
        return current($this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function next(): void
    {
        if ($this->data instanceof BidirectionalIterator) {
            $this->data->prev();
        } else {
            prev($this->data);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function prev(): void
    {
        if ($this->data instanceof BidirectionalIterator) {
            $this->data->next();
        } else {
            next($this->data);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function key()
    {
        if ($this->data instanceof BidirectionalIterator) {
            return $this->data->key();
        }
        return key($this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function valid(): bool
    {
        if ($this->data instanceof BidirectionalIterator) {
            return $this->data->valid();
        }
        return $this->key() !== null;
    }

    /**
     * {@inheritDoc}
     */
    public function rewind(): void
    {
        if ($this->data instanceof BidirectionalIterator) {
            $this->data->end();
        } else {
            end($this->data);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function end(): void
    {
        if ($this->data instanceof BidirectionalIterator) {
            $this->data->rewind();
        } else {
            reset($this->data);
        }
    }

    /**
     * {@inheritDoc}
     *
     * @return ArrayAccessForwardIterator<TKey, TValue>
     */
    public function reverse(): ArrayAccessForwardIterator
    {
        return new ArrayAccessForwardIterator($this->data);
    }

    /**
     * {@inheritDoc}
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
     * {@inheritDoc}
     */
    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    /**
     * {@inheritDoc}
     */
    public function offsetSet($offset, $value): void
    {
        /** @phpstan-ignore-next-line */
        $this->data[$offset] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function offsetUnset($offset): void
    {
        unset($this->data[$offset]);
    }
}
