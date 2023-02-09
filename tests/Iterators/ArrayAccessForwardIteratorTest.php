<?php

declare(strict_types=1);

namespace IterTools\Tests\Iterators;

use IterTools\Iterators\Interfaces\BidirectionalIterator;
use IterTools\Iterators\ArrayAccessForwardIterator;
use IterTools\Stream;
use IterTools\Tests\Fixture\RandomAccessFixture;

/**
 * @phpstan-type ArrayLike = array<int|string, mixed>|(\ArrayAccess<mixed, mixed>&BidirectionalIterator<mixed, mixed>)
 */
class ArrayAccessForwardIteratorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider dataProviderDirectRead
     * @param ArrayLike $input
     * @param array $expectedKeys
     * @param array $expectedValues
     * @return void
     */
    public function testDirectRead($input, array $expectedKeys, array $expectedValues): void
    {
        // Given
        $resultKeys = [];
        $resultValues = [];
        $iterator = new ArrayAccessForwardIterator($input);

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
        $wrap = fn (array $data) => new RandomAccessFixture($data);

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
            [
                $wrap([]),
                [],
                [],
            ],
            [
                $wrap([1]),
                [0],
                [1],
            ],
            [
                $wrap([1, 2, 3]),
                [0, 1, 2],
                [1, 2, 3],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForReverseRead
     * @param ArrayLike $input
     * @param array $expectedKeys
     * @param array $expectedValues
     * @return void
     */
    public function testReverseRead($input, array $expectedKeys, array $expectedValues): void
    {
        // Given
        $resultKeys = [];
        $resultValues = [];
        $iterator = new ArrayAccessForwardIterator($input);
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
        $wrap = fn (array $data) => new RandomAccessFixture($data);

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
            [
                $wrap([]),
                [],
                [],
            ],
            [
                $wrap([1]),
                [0],
                [1],
            ],
            [
                $wrap([1, 2, 3]),
                [2, 1, 0],
                [3, 2, 1],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForBidirectionalRead
     * @param ArrayLike $input
     * @param array $expectedKeys
     * @param array $expectedValues
     * @return void
     */
    public function testBidirectionalRead($input, array $expectedKeys, array $expectedValues): void
    {
        // Given
        $resultKeys = [];
        $resultValues = [];
        $iterator = new ArrayAccessForwardIterator($input);

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
        $wrap = fn (array $data) => new RandomAccessFixture($data);

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
            [
                $wrap([]),
                [],
                [],
            ],
            [
                $wrap([1]),
                [0, 0],
                [1, 1],
            ],
            [
                $wrap([1, 2, 3]),
                [0, 1, 2, 2, 1, 0],
                [1, 2, 3, 3, 2, 1],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForReadByIndexes
     * @param ArrayLike $input
     * @param array $expectedKeys
     * @param array $expectedValues
     * @return void
     */
    public function testReadByIndexes($input, array $expectedKeys, array $expectedValues): void
    {
        // Given
        $resultKeys = [];
        $resultValues = [];
        $iterator = new ArrayAccessForwardIterator($input);

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
        $wrap = fn (array $data) => new RandomAccessFixture($data);

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
            [
                $wrap([]),
                [],
                [],
            ],
            [
                $wrap([1]),
                [0],
                [1],
            ],
            [
                $wrap([1, 2, 3]),
                [0, 1, 2],
                [1, 2, 3],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForNotFullBidirectionalRead
     * @param ArrayLike $input
     * @param int $readCount
     * @param array $expectedKeys
     * @param array $expectedValues
     * @return void
     */
    public function testNotFullBidirectionalRead($input, int $readCount, array $expectedKeys, array $expectedValues): void
    {
        // Given
        $resultKeys = [];
        $resultValues = [];
        $iterator = new ArrayAccessForwardIterator($input);

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
        $wrap = fn (array $data) => new RandomAccessFixture($data);

        return [
            [
                [1, 2, 3, 4, 5],
                3,
                [0, 1, 2, 3, 2, 1, 0, 4, 3, 2, 1, 0],
                [1, 2, 3, 4, 3, 2, 1, 5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [0, 1, 2, 3, 2, 1, 0, 4, 3, 2, 1, 0],
                [1, 2, 3, 4, 3, 2, 1, 5, 4, 3, 2, 1],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForWrite
     * @param ArrayLike $input
     * @param callable $modifier
     * @param array $expectedStep1
     * @param array $expectedStep2
     * @return void
     */
    public function testWrite($input, callable $modifier, array $expectedStep1, array $expectedStep2): void
    {
        // Given
        $iterator = new ArrayAccessForwardIterator($input);

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
        $wrap = fn (array $data) => new RandomAccessFixture($data);

        return [
            [
                [1, 2, 3, 4, 5],
                fn ($value) => $value + 1,
                [2, 3, 4, 5, 6],
                [3, 4, 5, 6, 7],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                fn ($value) => $value + 1,
                [2, 3, 4, 5, 6],
                [3, 4, 5, 6, 7],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForUnset
     * @param ArrayLike $input
     * @param callable $predicate
     * @param array $expected
     * @return void
     */
    public function testUnset($input, callable $predicate, array $expected): void
    {
        // Given
        $iterator = new ArrayAccessForwardIterator($input);

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
     * @param ArrayLike $input
     * @param callable $predicate
     * @param array $expected
     * @return void
     */
    public function testUnsetReversed($input, callable $predicate, array $expected): void
    {
        // Given
        $iterator = new ArrayAccessForwardIterator($input);
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
        $wrap = fn (array $data) => new RandomAccessFixture($data);

        return [
            [
                [1, 2, 3, 4, 5],
                fn ($value) => $value % 2 === 0,
                [1, 3, 5],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                fn ($value) => $value % 2 === 0,
                [1, 3, 5],
            ],
        ];
    }
}
