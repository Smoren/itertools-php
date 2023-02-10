<?php

declare(strict_types=1);

namespace IterTools\Iterators\Traits;

use IterTools\Iterators\Interfaces\BidirectionalArrayAccessIterator;
use IterTools\Iterators\Interfaces\BidirectionalIterator;
use IterTools\Iterators\ArrayAccessForwardIterator;
use IterTools\Iterators\ArrayAccessReverseIterator;

/**
 * Trait for bidirectional iterable & ArrayAccess iterators.
 *
 * @see ArrayAccessForwardIterator
 * @see ArrayAccessReverseIterator
 *
 * @template TKey
 * @template TValue
 *
 * @implements BidirectionalArrayAccessIterator<TKey, TValue>
 *
 * @property BidirectionalArrayAccessIterator<TKey, TValue> $data
 */
trait ArrayAccessIteratorTrait
{
    /**
     * {@inheritDoc}
     */
    public function current()
    {
        return $this->data->current();
    }

    /**
     * {@inheritDoc}
     */
    public function key()
    {
        return $this->data->key();
    }

    /**
     * {@inheritDoc}
     */
    public function valid(): bool
    {
        return $this->data->valid();
    }

    /**
     * {@inheritDoc}
     */
    public function offsetExists($offset): bool
    {
        return $this->data->offsetExists($offset);
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
        if ($offset === null) {
            /** @phpstan-ignore-next-line */
            $this->data[] = $value;
        } else {
            /** @phpstan-ignore-next-line */
            $this->data[$offset] = $value;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function offsetUnset($offset): void
    {
        unset($this->data[$offset]);
    }
}
