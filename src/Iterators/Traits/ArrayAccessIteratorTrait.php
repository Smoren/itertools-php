<?php

declare(strict_types=1);

namespace IterTools\Iterators\Traits;

use IterTools\Iterators\Interfaces\ArrayAccessIterator;
use IterTools\Iterators\Interfaces\BidirectionalIterator;

/**
 * @template TKey
 * @template TValue
 *
 * @phpstan-type TArrayKey = (int&TKey)|(string&TKey)
 * @phpstan-type ArrayLike = array<TArrayKey, TValue>|(\ArrayAccess<TKey, TValue>&BidirectionalIterator<TKey, TValue>)
 *
 * @implements ArrayAccessIterator<TKey, TValue>
 *
 * @property ArrayLike $data
 */
trait ArrayAccessIteratorTrait
{
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
