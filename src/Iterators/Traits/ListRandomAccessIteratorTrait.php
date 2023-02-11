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
 * @property int<0, max> $index
 * @property int<0, max> $begin
 * @property int<0, max> $end
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
        return $this->index >= 0 && $this->index < \count($this);
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
    public function last(): void
    {
        $this->index = \count($this) - 1;
    }

    /**
     * {@inheritDoc}
     */
    public function count(): int
    {
        return $this->end - $this->start;
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
     * {@inheritDoc}
     *
     * @param int $offset
     */
    public function offsetExists($offset): bool
    {
        /** @var int $offset */
        $offset = $this->getIndex($offset);
        if ($this->data instanceof \ArrayAccess) {
            return $this->data->offsetExists($offset);
        }
        return array_key_exists($offset, $this->data);
    }

    /**
     * {@inheritDoc}
     *
     * @return T
     */
    public function offsetGet($offset)
    {
        return $this->data[$this->getIndex($offset)];
    }

    /**
     * {@inheritDoc}
     *
     * @param int|null $offset
     * @param T $value
     *
     * @throws \OutOfBoundsException
     */
    public function offsetSet($offset, $value): void
    {
        $offset = $this->getIndex($offset);

        if ($offset === null) {
            $this->data[] = $value;
            $this->end++;
        } elseif ($offset >= $this->start && $offset === $this->end) {
            $this->data[$offset] = $value;
            $this->end++;
        } elseif ($offset >= $this->start && $offset < $this->end) {
            $this->data[$offset] = $value;
        } else {
            throw new \OutOfBoundsException();
        }
    }

    /**
     * {@inheritDoc}
     *
     * @param int $offset
     *
     * @throws \OutOfBoundsException
     * @throws \InvalidArgumentException
     */
    public function offsetUnset($offset): void
    {
        $offset = $this->getIndex($offset);

        if ($offset >= $this->end || $offset < $this->start) {
            throw new \OutOfBoundsException();
        }

        if ($offset < $this->end - 1) {
            throw new \InvalidArgumentException();
        }

        if ($this->data instanceof \ArrayAccess) {
            unset($this->data[$offset]);
        } else {
            array_pop($this->data);
        }

        $this->end--;
    }
}
