<?php

declare(strict_types=1);

namespace IterTools\Iterators;

use IterTools\Iterators\Interfaces\RandomAccessIterator;
use IterTools\Iterators\Traits\ListRandomAccessIteratorTrait;

/**
 * Read/write array list array access iterator (reverse in foreach loop).
 *
 * @template T
 *
 * @phpstan-type ArrayAccessList = \ArrayAccess<int, T>&\Countable
 *
 * @implements RandomAccessIterator<int, T>
 */
class ListRandomAccessReverseIterator implements RandomAccessIterator, \Countable
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
        return $this->data[\count($this) - $this->index - 1];
    }

    /**
     * {@inheritDoc}
     *
     * @return ListRandomAccessForwardIterator<T>
     */
    public function reverse(): ListRandomAccessForwardIterator
    {
        /** @var ListRandomAccessForwardIterator<T> */
        return new ListRandomAccessForwardIterator($this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetExists($offset): bool
    {
        return $this->offsetExistsInternal(\count($this) - $offset - 1);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetGet($offset)
    {
        return $this->offsetGetInternal(\count($this) - $offset - 1);
    }

    /**
     * {@inheritDoc}
     *
     * @throws \OutOfBoundsException
     */
    public function offsetSet($offset, $value): void
    {
        $this->offsetSetInternal(
            $offset === null
                ? null
                : \count($this) - $offset - 1,
            $value
        );
    }

    /**
     * {@inheritDoc}
     *
     * @throws \OutOfBoundsException
     * @throws \InvalidArgumentException
     */
    public function offsetUnset($offset): void
    {
        $this->offsetUnsetInternal(\count($this) - $offset - 1);
    }
}
