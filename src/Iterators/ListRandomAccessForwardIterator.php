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
     * @param list<T>|ArrayAccessList $data
     */
    public function __construct(&$data)
    {
        $this->data = &$data;
        $this->index = 0;
    }

    /**
     * {@inheritDoc}
     *
     * @return T
     */
    public function current()
    {
        return $this->data[$this->index];
    }

    /**
     * {@inheritDoc}
     *
     * @return ListRandomAccessReverseIterator<T>
     */
    public function reverse(): ListRandomAccessReverseIterator
    {
        /** @var ListRandomAccessReverseIterator<T> */
        return new ListRandomAccessReverseIterator($this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetExists($offset): bool
    {
        return $this->offsetExistsInternal($offset);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetGet($offset)
    {
        return $this->offsetGetInternal($offset);
    }

    /**
     * {@inheritDoc}
     *
     * @throws \OutOfBoundsException
     */
    public function offsetSet($offset, $value): void
    {
        $this->offsetSetInternal($offset, $value);
    }

    /**
     * {@inheritDoc}
     *
     * @throws \OutOfBoundsException
     * @throws \InvalidArgumentException
     */
    public function offsetUnset($offset): void
    {
        $this->offsetUnsetInternal($offset);
    }
}
