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
     * @var array<TArrayKey, int>
     */
    protected array $keyMap;
    /**
     * @var int
     */
    protected int $currentIndex = 0;
    /**
     * @var TArrayKey|null
     */
    protected $currentKey = null;
    /**
     * @var int
     */
    protected int $start;
    /**
     * @var int
     */
    protected int $end;

    /**
     * @param array<TArrayKey, TValue> $data
     * @param int $start
     * @param int|null $end
     */
    public function __construct(array &$data, int $start = 0, ?int $end = null)
    {
        $this->data = &$data;
        $this->currentIndex = \count($this) - 1;
        $this->start = $start;
        $this->end = ($end !== null)
            ? \min($end, \count($this->data))
            : \count($this->data);
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
     * @param TKey $offset
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            $index = $this->keyMap[$offset];

            if ($index <= $this->currentIndex) {
                $this->currentIndex--;
            }

            $this->end--;

            unset($this->data[$offset]);
            $this->updateKeys();
            $this->updateCurrentKey();
        } else {
            throw new \OutOfBoundsException();
        }
    }

    /**
     * {@inheritDoc}
     *
     * @return ArrayRandomAccessForwardIterator<TArrayKey, TValue>
     */
    public function reverse(): ArrayRandomAccessForwardIterator
    {
        return new ArrayRandomAccessForwardIterator(
            $this->data,
            \count($this->data) - $this->end,
            \count($this->data) - $this->start
        );
    }

    /**
     * @param array<int, TArrayKey> $keys
     * @return array<int, TArrayKey>
     */
    protected function sliceKeys(array $keys): array
    {
        $start = \count($this->data) - $this->end;
        $end = \count($this->data) - $this->start;
        return \array_slice($keys, $start, $end - $start);
    }

    /**
     * @return void
     */
    protected function checkCanAppend(): void
    {
        if ($this->start !== 0) {
            throw new \RangeException();
        }
    }
}
