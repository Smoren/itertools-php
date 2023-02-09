<?php

declare(strict_types=1);

namespace IterTools\Iterators\Traits;

use IterTools\Iterators\Interfaces\ArrayAccessIterator;

/**
 * @template TKey
 * @template TValue
 *
 * @implements ArrayAccessIterator<TKey, TValue>
 *
 * @property array<TKey, TValue> $data
 */
trait ArrayIteratorTrait
{
    /**
     * {@inheritDoc}
     */
    public function current()
    {
        return current($this->data);
    }

    /**
     * {@inheritDoc}
     *
     * @return TKey|null
     */
    public function key()
    {
        return key($this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function valid(): bool
    {
        return $this->key() !== null;
    }
}
