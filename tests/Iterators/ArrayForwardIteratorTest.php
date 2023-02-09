<?php

declare(strict_types=1);

namespace IterTools\Tests\Iterators;

use IterTools\Iterators\ArrayForwardIterator;

class ArrayForwardIteratorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider dataProviderDirectRead
     * @param array $input
     * @param array $expectedKeys
     * @param array $expectedValues
     * @return void
     */
    public function testDirectRead(array $input, array $expectedKeys, array $expectedValues): void
    {
        // Given
        $resultKeys = [];
        $resultValues = [];
        $iterator = new ArrayForwardIterator($input);

        // When
        foreach ($iterator as $key => $value) {
            $resultKeys[] = $key;
            $resultValues[] = $value;
        }

        // Then
        $this->assertEquals($expectedKeys, $resultKeys);
        $this->assertEquals($expectedValues, $resultValues);

        // And When
        $resultKeys = [];
        $resultValues = [];
        $iterator = $iterator->reverse();
        $iterator = $iterator->reverse();

        foreach ($iterator as $key => $value) {
            $resultKeys[] = $key;
            $resultValues[] = $value;
        }

        // Then
        $this->assertEquals($expectedKeys, $resultKeys);
        $this->assertEquals($expectedValues, $resultValues);
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
                [],
            ],
            [
                [1],
                [0],
                [1],
            ],
            [
                [1, 2, 3],
                [0, 1, 2],
                [1, 2, 3],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForReverseRead
     * @param array $input
     * @param array $expectedKeys
     * @param array $expectedValues
     * @return void
     */
    public function testReverseRead(array $input, array $expectedKeys, array $expectedValues): void
    {
        // Given
        $resultKeys = [];
        $resultValues = [];
        $iterator = new ArrayForwardIterator($input);
        $iterator = $iterator->reverse();

        // When
        foreach ($iterator as $key => $value) {
            $resultKeys[] = $key;
            $resultValues[] = $value;
        }

        // Then
        $this->assertEquals($expectedKeys, $resultKeys);
        $this->assertEquals($expectedValues, $resultValues);
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
                [],
            ],
            [
                [1],
                [0],
                [1],
            ],
            [
                [1, 2, 3],
                [2, 1, 0],
                [3, 2, 1],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForBidirectionalRead
     * @param array $input
     * @param array $expectedKeys
     * @param array $expectedValues
     * @return void
     */
    public function testBidirectionalRead(array $input, array $expectedKeys, array $expectedValues): void
    {
        // Given
        $resultKeys = [];
        $resultValues = [];
        $iterator = new ArrayForwardIterator($input);

        // When
        foreach ($iterator as $key => $value) {
            $resultKeys[] = $key;
            $resultValues[] = $value;
        }

        // And when
        $iterator = $iterator->reverse();
        foreach ($iterator as $key => $value) {
            $resultKeys[] = $key;
            $resultValues[] = $value;
        }

        // Then
        $this->assertEquals($expectedKeys, $resultKeys);
        $this->assertEquals($expectedValues, $resultValues);
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
                [],
            ],
            [
                [1],
                [0, 0],
                [1, 1],
            ],
            [
                [1, 2, 3],
                [0, 1, 2, 2, 1, 0],
                [1, 2, 3, 3, 2, 1],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForNotFullBidirectionalRead
     * @param array $input
     * @param int $readCount
     * @param array $expectedKeys
     * @param array $expectedValues
     * @return void
     */
    public function testNotFullBidirectionalRead(array $input, int $readCount, array $expectedKeys, array $expectedValues): void
    {
        // Given
        $resultKeys = [];
        $resultValues = [];
        $iterator = new ArrayForwardIterator($input);

        // When
        $iterator->rewind();
        for ($i = 0; $i < $readCount; ++$i) {
            $resultKeys[] = $iterator->key();
            $resultValues[] = $iterator->current();
            $iterator->next();
        }

        // And when
        while ($iterator->valid()) {
            $resultKeys[] = $iterator->key();
            $resultValues[] = $iterator->current();
            $iterator->prev();
        }

        // And when
        $iterator->end();
        while ($iterator->valid()) {
            $resultKeys[] = $iterator->key();
            $resultValues[] = $iterator->current();
            $iterator->prev();
        }

        // Then
        $this->assertEquals($expectedKeys, $resultKeys);
        $this->assertEquals($expectedValues, $resultValues);
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
                [0, 1, 2, 3, 2, 1, 0, 4, 3, 2, 1, 0],
                [1, 2, 3, 4, 3, 2, 1, 5, 4, 3, 2, 1],
            ],
        ];
    }
}
