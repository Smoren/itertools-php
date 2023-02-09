<?php

declare(strict_types=1);

namespace IterTools\Iterators\Interfaces;

/**
 * @template TKey
 * @template TValue
 *
 * @extends ArrayAccessIterator<TKey, TValue>
 */
interface RandomAccessIterator extends ArrayAccessIterator
{
    /**
     * @param int $steps
     *
     * @return void
     *
     * @throws \OutOfBoundsException
     */
    public function move(int $steps): void;
}
