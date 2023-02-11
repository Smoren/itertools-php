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
     * @return ListRandomAccessForwardIterator<T>
     */
    public function reverse(): ListRandomAccessForwardIterator
    {
        /** @var ListRandomAccessForwardIterator<T> */
        return new ListRandomAccessForwardIterator(
            $this->data,
            \count($this->data) - $this->end,
            \count($this->data) - $this->start
        );
    }

    /**
     * @param int|null $offset
     * @return int|null
     */
    protected function getIndex(?int $offset): ?int
    {
        if ($offset === null) {
            return null;
        }

        return \count($this->data) - $this->start - $offset - 1;
    }
}
