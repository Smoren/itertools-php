<?php

declare(strict_types=1);

namespace IterTools\Tests\Iterators;

use IterTools\Iterators\BidirectionalIterator;
use IterTools\Iterators\RandomAccessDirectIterator;
use IterTools\Tests\Fixture\RandomAccessFixture;

/**
 * @phpstan-type RandomAccess = array<int|string, mixed>|(\ArrayAccess<mixed, mixed>&BidirectionalIterator<mixed, mixed>)
 */
class RandomAccessDirectIteratorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider dataProviderDirectRead
     * @param RandomAccess $input
     * @param array $expected
     * @return void
     */
    public function testDirectRead($input, array $expected): void
    {
        // Given
        $result = [];
        $iterator = new RandomAccessDirectIterator($input);

        // When
        foreach ($iterator as $item) {
            $result[] = $item;
        }

        // Then
        $this->assertEquals($expected, $result);

        // And When
        $result = [];
        $iterator = $iterator->reverse();
        $iterator = $iterator->reverse();

        foreach ($iterator as $item) {
            $result[] = $item;
        }

        // Then
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function dataProviderDirectRead(): array
    {
        $wrap = fn (array $data) => new RandomAccessFixture($data);

        return [
            [
                [],
                [],
            ],
            [
                [1],
                [1],
            ],
            [
                [1, 2, 3],
                [1, 2, 3],
            ],
            [
                $wrap([]),
                [],
            ],
            [
                $wrap([1]),
                [1],
            ],
            [
                $wrap([1, 2, 3]),
                [1, 2, 3],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForReverseRead
     * @param RandomAccess $input
     * @param array $expected
     * @return void
     */
    public function testReverseRead($input, array $expected): void
    {
        // Given
        $result = [];
        $iterator = new RandomAccessDirectIterator($input);
        $iterator = $iterator->reverse();

        // When
        foreach ($iterator as $item) {
            $result[] = $item;
        }

        // Then
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function dataProviderForReverseRead(): array
    {
        $wrap = fn (array $data) => new RandomAccessFixture($data);

        return [
            [
                [],
                [],
            ],
            [
                [1],
                [1],
            ],
            [
                [1, 2, 3],
                [3, 2, 1],
            ],
            [
                $wrap([]),
                [],
            ],
            [
                $wrap([1]),
                [1],
            ],
            [
                $wrap([1, 2, 3]),
                [3, 2, 1],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForBidirectionalRead
     * @param RandomAccess $input
     * @param array $expected
     * @return void
     */
    public function testBidirectionalRead($input, array $expected): void
    {
        // Given
        $result = [];
        $iterator = new RandomAccessDirectIterator($input);

        // When
        foreach ($iterator as $item) {
            $result[] = $item;
        }

        // And when
        $iterator = $iterator->reverse();
        foreach ($iterator as $item) {
            $result[] = $item;
        }

        // Then
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function dataProviderForBidirectionalRead(): array
    {
        $wrap = fn (array $data) => new RandomAccessFixture($data);

        return [
            [
                [],
                [],
            ],
            [
                [1],
                [1, 1],
            ],
            [
                [1, 2, 3],
                [1, 2, 3, 3, 2, 1],
            ],
            [
                $wrap([]),
                [],
            ],
            [
                $wrap([1]),
                [1, 1],
            ],
            [
                $wrap([1, 2, 3]),
                [1, 2, 3, 3, 2, 1],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForNotFullBidirectionalRead
     * @param RandomAccess $input
     * @param int $readCount
     * @param array $expected
     * @return void
     */
    public function testNotFullBidirectionalRead($input, int $readCount, array $expected): void
    {
        // Given
        $result = [];
        $iterator = new RandomAccessDirectIterator($input);

        // When
        $iterator->rewind();
        for ($i = 0; $i < $readCount; ++$i) {
            $result[] = $iterator->current();
            $iterator->next();
        }

        // And when
        $iterator = $iterator->reverse();
        while ($iterator->valid()) {
            $result[] = $iterator->current();
            $iterator->next();
        }

        // And when
        $iterator = $iterator->reverse();
        $iterator->rewind();
        while ($iterator->valid()) {
            $result[] = $iterator->current();
            $iterator->next();
        }

        // Then
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function dataProviderForNotFullBidirectionalRead(): array
    {
        $wrap = fn (array $data) => new RandomAccessFixture($data);

        return [
            [
                [1, 2, 3, 4, 5],
                3,
                [1, 2, 3, 4, 3, 2, 1, 1, 2, 3, 4, 5],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [1, 2, 3, 4, 3, 2, 1, 1, 2, 3, 4, 5],
            ],
        ];
    }
}
