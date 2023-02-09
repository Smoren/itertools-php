<?php

declare(strict_types=1);

namespace IterTools\Tests\Iterators;

use IterTools\Iterators\ArrayRandomAccessForwardIterator;
use IterTools\Iterators\Interfaces\BidirectionalIterator;
use IterTools\Stream;

/**
 * @phpstan-type ArrayLike = array<int|string, mixed>|(\ArrayAccess<mixed, mixed>&BidirectionalIterator<mixed, mixed>)
 */
class ArrayRandomAccessForwardIteratorTest extends \PHPUnit\Framework\TestCase
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
        $iterator = new ArrayRandomAccessForwardIterator($input);

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
        $iterator = new ArrayRandomAccessForwardIterator($input);
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
        $iterator = new ArrayRandomAccessForwardIterator($input);

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
     * @dataProvider dataProviderForReadByIndexes
     * @param array $input
     * @param array $expectedKeys
     * @param array $expectedValues
     * @return void
     */
    public function testReadByIndexes(array $input, array $expectedKeys, array $expectedValues): void
    {
        // Given
        $resultKeys = [];
        $resultValues = [];
        $iterator = new ArrayRandomAccessForwardIterator($input);

        // When
        for ($i=0; $i<count($input); ++$i) {
            if (!isset($iterator[$i])) {
                $this->fail();
            }

            $resultKeys[] = $i;
            $resultValues[] = $iterator[$i];
        }

        // Then
        $this->assertEquals($expectedKeys, $resultKeys);
        $this->assertEquals($expectedValues, $resultValues);
    }

    /**
     * @return array[]
     */
    public function dataProviderForReadByIndexes(): array
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
        $iterator = new ArrayRandomAccessForwardIterator($input);

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

    /**
     * @dataProvider dataProviderForWrite
     * @param array $input
     * @param callable $modifier
     * @param array $expectedStep1
     * @param array $expectedStep2
     * @return void
     */
    public function testWrite(array $input, callable $modifier, array $expectedStep1, array $expectedStep2): void
    {
        // Given
        $iterator = new ArrayRandomAccessForwardIterator($input);

        // When
        foreach ($iterator as $key => $value) {
            $iterator[$key] = $modifier($value);
        }

        // Then
        $this->assertEquals($expectedStep1, Stream::of($input)->toArray());

        // And when
        $iterator = $iterator->reverse();
        foreach ($iterator as $key => $value) {
            $iterator[$key] = $modifier($value);
        }

        // Then
        $this->assertEquals($expectedStep2, Stream::of($input)->toArray());
    }

    /**
     * @return array[]
     */
    public function dataProviderForWrite(): array
    {
        return [
            [
                [1, 2, 3, 4, 5],
                fn ($value) => $value + 1,
                [2, 3, 4, 5, 6],
                [3, 4, 5, 6, 7],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForUnset
     * @param array $input
     * @param callable $predicate
     * @param array $expected
     * @return void
     */
    public function testUnset(array $input, callable $predicate, array $expected): void
    {
        // Given
        $iterator = new ArrayRandomAccessForwardIterator($input);

        // When
        foreach ($iterator as $key => $value) {
            if ($predicate($value)) {
                unset($iterator[$key]);
            }
        }

        // Then
        $this->assertEquals($expected, Stream::of($input)->toArray());
    }

    /**
     * @dataProvider dataProviderForUnset
     * @param array $input
     * @param callable $predicate
     * @param array $expected
     * @return void
     */
    public function testUnsetReversed(array $input, callable $predicate, array $expected): void
    {
        // Given
        $iterator = new ArrayRandomAccessForwardIterator($input);
        $iterator = $iterator->reverse();

        // When
        foreach ($iterator as $key => $value) {
            if ($predicate($value)) {
                unset($iterator[$key]);
            }
        }

        // Then
        $this->assertEquals($expected, Stream::of($input)->toArray());
    }

    /**
     * @return array[]
     */
    public function dataProviderForUnset(): array
    {
        return [
            [
                [1, 2, 3, 4, 5],
                fn ($value) => $value % 2 === 0,
                [1, 3, 5],
            ],
        ];
    }
}
