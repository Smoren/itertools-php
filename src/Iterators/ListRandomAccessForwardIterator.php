<?php

declare(strict_types=1);

namespace IterTools\Iterators;

use IterTools\Iterators\Interfaces\RandomAccessIterator;
use IterTools\Iterators\Traits\ListRandomAccessIteratorTrait;

/**
 * Read/write array list array access iterator (forward in foreach loop).
 *
 * @template T
 *
 * @phpstan-type ArrayAccessList = \ArrayAccess<int, T>&\Countable
 *
 * @implements RandomAccessIterator<int, T>
 */
class ListRandomAccessForwardIterator implements RandomAccessIterator, \Countable
{
    /**
     * @use ListRandomAccessIteratorTrait<T>
     */
    use ListRandomAccessIteratorTrait;

    /**
     * @var list<T>|ArrayAccessList
     */
    protected $data;
    /**
     * @var int
     */
    protected int $index;
    /**
     * @var int
     */
    protected int $start;
    /**
     * @var int
     */
    protected int $end;

    /**
     * @param list<T>|ArrayAccessList $data
     * @param int $start
     * @param int|null $end
     */
    public function __construct(&$data, int $start = 0, ?int $end = null)
    {
        $this->data = &$data;
        $this->index = 0;
        $this->start = \max($start, 0);
        $this->end = ($end !== null)
            ? \min($end, \count($this->data))
            : \count($this->data);
    }

    /**
     * {@inheritDoc}
     *
     * @return T
     */
    public function current()
    {
        return $this->data[$this->getIndex($this->index)];
    }

    /**
     * {@inheritDoc}
     *
     * @return ListRandomAccessReverseIterator<T>
     */
    public function reverse(): ListRandomAccessReverseIterator
    {
        /** @var ListRandomAccessReverseIterator<T> */
        return new ListRandomAccessReverseIterator(
            $this->data,
            \count($this->data) - $this->end,
            \count($this->data) - $this->start
        );
    }

    /**
     * Allowed updating existing item and appending item to the tail of iterator.
     *
     * Appending denied if end of container and end of iterator do not match.
     *
     * {@inheritDoc}
     *
     * @param int|null $offset
     * @param T $value
     *
     * @throws \OutOfBoundsException if index is out of iterator bounds
     * @throws \RangeException when appending item if end of container and end of iterator do not match
     */
    public function offsetSet($offset, $value): void
    {
        $range = $this->end - $this->start;

        if ($offset !== null && ($offset < 0 || $offset > $range)) {
            throw new \OutOfBoundsException();
        }

        if ($this->end !== \count($this->data) && $offset === $range) {
            throw new \RangeException();
        }

        if ($offset !== null && $offset !== $range) {
            $this->data[$this->getIndex($offset)] = $value;
            return;
        }

        if ($offset === null) {
            $this->data[] = $value;
        } else {
            $this->data[$this->getIndex($offset)] = $value;
        }

        $this->end++;
    }

    /**
     * Removing allowed only from tail of the iterator.
     *
     * Removing denied if end of container and end of iterator do not match.
     *
     * {@inheritDoc}
     *
     * @param int $offset
     *
     * @throws \OutOfBoundsException if index is out of iterator bounds
     * @throws \InvalidArgumentException if index is not last
     * @throws \RangeException if end of container and end of iterator do not match
     */
    public function offsetUnset($offset): void
    {
        $range = $this->end - $this->start;

        if ($range === 0 || $offset < 0 || $offset >= $range) {
            throw new \OutOfBoundsException();
        }

        if ($offset !== $range - 1) {
            throw new \InvalidArgumentException();
        }

        if ($this->end !== \count($this->data)) {
            throw new \RangeException();
        }

        if ($this->data instanceof \ArrayAccess) {
            unset($this->data[$this->getIndex($offset)]);
        } else {
            array_pop($this->data);
        }

        $this->end--;
    }

    /**
     * @param int $offset
     * @return int
     */
    protected function getIndex(int $offset): int
    {
        return $this->start + $offset;
    }
}
