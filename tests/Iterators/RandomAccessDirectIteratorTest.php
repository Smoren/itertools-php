<?php

declare(strict_types=1);

namespace IterTools\Tests\Iterators;

use IterTools\Iterators\RandomAccessDirectIterator;

class RandomAccessDirectIteratorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider dataProviderDirectRead
     * @param array $input
     * @param array $expected
     * @return void
     */
    public function testDirectRead(array $input, array $expected): void
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
        ];
    }

    /**
     * @dataProvider dataProviderForReverseRead
     * @param array $input
     * @param array $expected
     * @return void
     */
    public function testReverseRead(array $input, array $expected): void
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
        ];
    }

    /**
     * @dataProvider dataProviderForBidirectionalRead
     * @param array $input
     * @param array $expected
     * @return void
     */
    public function testBidirectionalRead(array $input, array $expected): void
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
        ];
    }

    /**
     * @dataProvider dataProviderForNotFullBidirectionalRead
     * @param array $input
     * @param int $readCount
     * @param array $expected
     * @return void
     */
    public function testNotFullBidirectionalRead(array $input, int $readCount, array $expected): void
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

        // Then
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function dataProviderForNotFullBidirectionalRead(): array
    {
        return [
            [
                [1, 2, 3, 4, 5],
                3,
                [1, 2, 3, 4, 3, 2, 1],
            ],
        ];
    }
}
