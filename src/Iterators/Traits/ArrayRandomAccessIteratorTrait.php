<?php

declare(strict_types=1);

namespace IterTools\Iterators\Traits;

use IterTools\Iterators\ArrayRandomAccessForwardIterator;
use IterTools\Iterators\ArrayRandomAccessReverseIterator;
use IterTools\Iterators\Interfaces\RandomAccessIterator;

/**
 * Trait for array random access iterators.
 *
 * @see ArrayRandomAccessForwardIterator
 * @see ArrayRandomAccessReverseIterator
 *
 * @template TKey
 * @template TValue
 *
 * @phpstan-type TArrayKey = (int&TKey)|(string&TKey)
 *
 * @implements RandomAccessIterator<TArrayKey, TValue>
 *
 * @property array<TArrayKey, TValue> $data
 * @property array<int, TArrayKey> $keys
 * @property int $currentIndex
 * @property TArrayKey|null $currentKey
 */
trait ArrayRandomAccessIteratorTrait
{
    /**
     * {@inheritDoc}
     */
    public function current()
    {
        return $this->data[$this->currentKey];
    }

    /**
     * {@inheritDoc}
     *
     * @return TKey|null
     */
    public function key()
    {
        return $this->currentKey;
    }

    /**
     * {@inheritDoc}
     */
    public function valid(): bool
    {
        return $this->currentKey !== null;
    }

    /**
     * {@inheritDoc}
     */
    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->data);
    }

    /**
     * {@inheritDoc}
     *
     * @return TValue
     */
    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    /**
     * {@inheritDoc}
     *
     * @param TKey|null $offset
     * @param TValue $value
     */
    public function offsetSet($offset, $value): void
    {
        if ($offset === null) {
            /** @phpstan-ignore-next-line */
            $this->data[] = $value;
            $this->updateKeys();
        } elseif (!$this->offsetExists($offset)) {
            $this->data[$offset] = $value;
            $this->updateKeys();
        } else {
            $this->data[$offset] = $value;
        }
    }

    /**
     * {@inheritDoc}
     *
     * @param TKey $offset
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            $index = array_search($offset, $this->keys);

            if ($index < $this->currentIndex) {
                $this->currentIndex--;
            }

            unset($this->data[$offset]);
            $this->updateKeys();
        }
    }

    /**
     * @return void
     */
    protected function updateKeys(): void
    {
        $this->keys = array_keys($this->data);
    }

    /**
     * @return void
     */
    protected function updateCurrentKey(): void
    {
        if ($this->currentIndex < 0) {
            $this->currentIndex = -1;
            $this->currentKey = null;
        } elseif ($this->currentIndex >= count($this->keys)) {
            $this->currentIndex = count($this->keys);
            $this->currentKey = null;
        } else {
            $this->currentKey = $this->keys[$this->currentIndex];
        }
    }
}
