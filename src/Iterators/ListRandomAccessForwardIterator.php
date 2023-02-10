<?php

declare(strict_types=1);

namespace IterTools\Iterators;

use IterTools\Iterators\Interfaces\ArrayAccessList;
use Symfony\Component\DependencyInjection\Exception\BadMethodCallException;

/**
 * Read/write array list array access iterator (forward in foreach loop).
 *
 * @template T
 *
 * @extends ListBidirectionalForwardIterator<T>
 *
 * @implements ArrayAccessList<T>
 */
class ListRandomAccessForwardIterator extends ListBidirectionalForwardIterator implements ArrayAccessList
{
    /**
     * {@inheritDoc}
     */
    public function offsetExists($offset): bool
    {
        if ($this->data instanceof ArrayAccessList) {
            return $this->data->offsetExists($offset);
        }
        return array_key_exists($offset, $this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetGet($offset)
    {
        if ($this->data instanceof ArrayAccessList) {
            return $this->data->offsetGet($offset);
        }
        return $this->data[$offset];
    }

    /**
     * {@inheritDoc}
     *
     * @throws \OutOfBoundsException
     */
    public function offsetSet($offset, $value): void
    {
        if ($offset === null) {
            $this->data[] = $value;
        } elseif ($offset <= count($this->data)) {
            $this->data[$offset] = $value;
        } else {
            throw new \OutOfBoundsException();
        }
    }

    /**
     * {@inheritDoc}
     *
     * @throws \BadMethodCallException always
     */
    public function offsetUnset($offset): void
    {
        throw new BadMethodCallException('Not supported');
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
}
