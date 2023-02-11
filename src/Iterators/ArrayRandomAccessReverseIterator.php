<?php

declare(strict_types=1);

namespace IterTools\Iterators;

use IterTools\Iterators\Interfaces\RandomAccessIterator;
use IterTools\Iterators\Traits\ArrayRandomAccessIteratorTrait;

/**
 * Read/write array random access iterator (reverse in foreach loop).
 *
 * @template TKey
 * @template TValue
 *
 * @phpstan-type TArrayKey = TKey & array-key
 *
 * @implements RandomAccessIterator<TArrayKey, TValue>
 */
class ArrayRandomAccessReverseIterator implements RandomAccessIterator, \Countable
{
    /**
     * @use ArrayRandomAccessIteratorTrait<TArrayKey, TValue>
     */
    use ArrayRandomAccessIteratorTrait;

    /**
     * @var array<TArrayKey, TValue>
     */
    protected array $data;
    /**
     * @var array<int, TArrayKey>
     */
    protected array $keys;
    /**
     * @var int
     */
    protected int $currentIndex = 0;
    /**
     * @var TArrayKey|null
     */
    protected $currentKey = null;

    /**
     * @param array<TArrayKey, TValue> $data
     */
    public function __construct(array &$data)
    {
        $this->data = &$data;
        $this->updateKeys();
    }

    /**
     * {@inheritDoc}
     */
    public function next(): void
    {
        if ($this->currentIndex < 0) {
            $this->currentIndex = -1;
            $this->currentKey = null;
            return;
        }

        $this->currentKey = $this->keys[--$this->currentIndex] ?? null;
    }

    /**
     * {@inheritDoc}
     */
    public function prev(): void
    {
        if ($this->currentIndex >= \count($this->keys)) {
            $this->currentIndex = \count($this->keys);
            $this->currentKey = null;
            return;
        }

        $this->currentKey = $this->keys[++$this->currentIndex] ?? null;
    }

    /**
     * {@inheritDoc}
     */
    public function rewind(): void
    {
        $this->currentKey = $this->keys[$this->currentIndex = \count($this->keys) - 1] ?? null;
    }

    /**
     * {@inheritDoc}
     */
    public function last(): void
    {
        $this->currentKey = $this->keys[$this->currentIndex = 0] ?? null;
    }

    /**
     * {@inheritDoc}
     */
    public function movePointer(int $steps): void
    {
        $this->currentIndex -= $steps;
        $this->updateCurrentKey();
    }

    /**
     * {@inheritDoc}
     *
     * @return ArrayRandomAccessForwardIterator<TArrayKey, TValue>
     */
    public function reverse(): ArrayRandomAccessForwardIterator
    {
        return new ArrayRandomAccessForwardIterator($this->data);
    }
}
