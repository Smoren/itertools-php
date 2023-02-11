<?php

namespace IterTools\Iterators\Traits;

use IterTools\Iterators\Interfaces\BidirectionalIterator;
use IterTools\Iterators\ListRandomAccessForwardIterator;
use IterTools\Iterators\ListRandomAccessReverseIterator;

/**
 * Trait for bidirectional array list iterators.
 *
 * @see ListRandomAccessForwardIterator
 * @see ListRandomAccessReverseIterator
 *
 * @template T
 *
 * @phpstan-type ArrayAccessList = \ArrayAccess<int, T>&\Countable
 *
 * @implements BidirectionalIterator<int, T>
 *
 * @property list<T>|ArrayAccessList<T> $data
 * @property int $index
 */
trait ListRandomAccessIteratorTrait
{
    /**
     * {@inheritDoc}
     *
     * @return int
     */
    public function key(): int
    {
        return $this->index;
    }

    /**
     * {@inheritDoc}
     */
    public function valid(): bool
    {
        return $this->index >= 0 && $this->index < \count($this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function next(): void
    {
        if ($this->valid()) {
            $this->index++;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function prev(): void
    {
        if ($this->valid()) {
            $this->index--;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function rewind(): void
    {
        $this->index = 0;
    }

    /**
     * {@inheritDoc}
     */
    public function end(): void
    {
        $this->index = \count($this) - 1;
    }

    /**
     * {@inheritDoc}
     */
    public function count(): int
    {
        return \count($this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function movePointer(int $steps): void
    {
        $this->index += $steps;

        if ($this->index < 0) {
            $this->index = -1;
        } elseif ($this->index >= \count($this)) {
            $this->index = \count($this);
        }
    }

    /**
     * @param int $offset
     *
     * @return bool
     */
    protected function offsetExistsInternal(int $offset): bool
    {
        if ($this->data instanceof \ArrayAccess) {
            return $this->data->offsetExists($offset);
        }
        return array_key_exists($offset, $this->data);
    }

    /**
     * @param int $offset
     *
     * @return T|null
     */
    protected function offsetGetInternal(int $offset)
    {
        if ($this->data instanceof \ArrayAccess) {
            return $this->data->offsetGet($offset);
        }
        return $this->data[$offset];
    }

    /**
     * @param int|null $offset
     * @param T $value
     *
     * @throws \OutOfBoundsException
     */
    protected function offsetSetInternal($offset, $value): void
    {
        if ($offset === null) {
            $this->data[] = $value;
        } elseif ($offset <= \count($this)) {
            $this->data[$offset] = $value;
        } else {
            throw new \OutOfBoundsException();
        }
    }

    /**
     * @param int $offset
     *
     * @throws \OutOfBoundsException
     * @throws \InvalidArgumentException
     */
    protected function offsetUnsetInternal(int $offset): void
    {
        if ($offset >= \count($this) || $offset < 0) {
            throw new \OutOfBoundsException();
        }

        if ($offset < \count($this) - 1) {
            throw new \InvalidArgumentException();
        }

        unset($this->data[$offset]);
    }
}
