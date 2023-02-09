<?php

namespace IterTools\Tests\Fixture;

use IterTools\Iterators\Interfaces\BidirectionalIterator;

/**
 * @template TKey
 * @template TValue
 */
class BidirectionalIterableArrayAccessIteratorFixture implements BidirectionalIterator, \ArrayAccess, \Countable
{
    /**
     * @var array<TKey, TValue>
     */
    protected array $data;

    /**
     * @param array<TKey, TValue> $data
     */
    public function __construct(array &$data)
    {
        $this->data = &$data;
    }

    /**
     * @return TValue|false
     */
    public function current()
    {
        return current($this->data);
    }

    /**
     * @return TKey|null
     */
    public function key()
    {
        return key($this->data);
    }

    /**
     * @return void
     */
    public function next(): void
    {
        next($this->data);
    }

    /**
     * @return void
     */
    public function prev(): void
    {
        prev($this->data);
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return key($this->data) !== null;
    }

    /**
     * @return void
     */
    public function rewind(): void
    {
        reset($this->data);
    }

    /**
     * @return void
     */
    public function end(): void
    {
        end($this->data);
    }

    /**
     * @param TKey $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->data);
    }

    /**
     * @param TKey $offset
     * @return TValue
     */
    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    /**
     * @param TKey $offset
     * @param TValue $value
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        if ($offset === null) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    /**
     * @param TKey $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->data);
    }
}
