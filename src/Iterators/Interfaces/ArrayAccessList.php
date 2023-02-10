<?php

namespace IterTools\Iterators\Interfaces;

/**
 * @template T
 *
 * @extends \ArrayAccess<int, T>
 */
interface ArrayAccessList extends \ArrayAccess, \Countable
{
    /**
     * @param int $offset
     *
     * @return bool
     */
    public function offsetExists($offset): bool;

    /**
     * @param int $offset
     *
     * @return T
     */
    public function offsetGet($offset);

    /**
     * @param int $offset
     * @param T $value
     *
     * @return void
     */
    public function offsetSet($offset, $value): void;

    /**
     * @param int $offset
     *
     * @return void
     */
    public function offsetUnset($offset): void;
}
