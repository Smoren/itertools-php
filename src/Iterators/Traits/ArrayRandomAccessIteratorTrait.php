<?php

declare(strict_types=1);

namespace IterTools\Iterators\Traits;

use IterTools\Iterators\Interfaces\RandomAccessIterator;

/**
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
     * @param TKey $offset
     * @param TValue $value
     */
    public function offsetSet($offset, $value): void
    {
        if (!$this->offsetExists($offset)) {
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
        } else {
            unset($this->data[$offset]);
        }
    }

    /**
     * @return void
     */
    protected function updateKeys(): void
    {
        $this->keys = array_keys($this->data);
    }
}
