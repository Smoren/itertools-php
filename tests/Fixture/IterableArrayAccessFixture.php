<?php

namespace IterTools\Tests\Fixture;

use IterTools\Iterators\Interfaces\BidirectionalArrayAccessIterator;
use IterTools\Iterators\Interfaces\BidirectionalArrayAccessIteratorAggregate;

/**
 * @template TKey
 * @template TValue
 */
class IterableArrayAccessFixture implements BidirectionalArrayAccessIteratorAggregate, \Countable
{
    /**
     * @var array<TKey, TValue>
     */
    protected array $data;

    /**
     * @param array<TKey, TValue> $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return BidirectionalArrayAccessIterator
     */
    public function getIterator(): BidirectionalArrayAccessIterator
    {
        return new IterableArrayAccessIteratorFixture($this->data);
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
