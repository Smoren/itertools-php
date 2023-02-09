<?php

declare(strict_types=1);

namespace IterTools\Tests\Iterators;

use IterTools\Iterators\Interfaces\BidirectionalIterator;
use IterTools\Iterators\BidirectionalArrayAccessForwardIterator;
use IterTools\Stream;
use IterTools\Tests\Fixture\BidirectionalIterableArrayAccessFixture;
use IterTools\Tests\Fixture\BidirectionalIterableArrayAccessIteratorFixture;

/**
 * @phpstan-type IterableArrayAccess = array<int|string, mixed>|(\ArrayAccess<mixed, mixed>&BidirectionalIterator<mixed, mixed>)
 */
class BidirectionalArrayAccessForwardIteratorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider dataProviderDirectReadArray
     * @dataProvider dataProviderDirectReadIterator
     * @dataProvider dataProviderDirectReadIteratorAggregate
     * @param IterableArrayAccess $input
     * @param array $expectedKeys
     * @param array $expectedValues
     * @return void
     */
    public function testDirectRead($input, array $expectedKeys, array $expectedValues): void
    {
        // Given
        $resultKeys = [];
        $resultValues = [];
        $iterator = new BidirectionalArrayAccessForwardIterator($input);

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
    public function dataProviderDirectReadArray(): array
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
     * @return array[]
     */
    public function dataProviderDirectReadIterator(): array
    {
        $wrap = fn (array $data) => new BidirectionalIterableArrayAccessIteratorFixture($data);

        return [
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
     * @return array[]
     */
    public function dataProviderDirectReadIteratorAggregate(): array
    {
        $wrap = fn (array $data) => new BidirectionalIterableArrayAccessFixture($data);

        return [
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
     * @dataProvider dataProviderForReverseReadArray
     * @dataProvider dataProviderForReverseReadIterator
     * @dataProvider dataProviderForReverseReadIteratorAggregate
     * @param IterableArrayAccess $input
     * @param array $expectedKeys
     * @param array $expectedValues
     * @return void
     */
    public function testReverseReadByReverting($input, array $expectedKeys, array $expectedValues): void
    {
        // Given
        $resultKeys = [];
        $resultValues = [];
        $iterator = new BidirectionalArrayAccessForwardIterator($input);
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
     * @dataProvider dataProviderForReverseReadArray
     * @dataProvider dataProviderForReverseReadIterator
     * @dataProvider dataProviderForReverseReadIteratorAggregate
     * @param IterableArrayAccess $input
     * @param array $expectedKeys
     * @param array $expectedValues
     * @return void
     */
    public function testReverseReadByUsingPrev($input, array $expectedKeys, array $expectedValues): void
    {
        // Given
        $resultKeys = [];
        $resultValues = [];
        $iterator = new BidirectionalArrayAccessForwardIterator($input);

        // When
        for ($iterator->end(); $iterator->valid(); $iterator->prev()) {
            $resultKeys[] = $iterator->key();
            $resultValues[] = $iterator->current();
        }

        // Then
        $this->assertEquals($expectedKeys, $resultKeys);
        $this->assertEquals($expectedValues, $resultValues);
    }

    /**
     * @return array[]
     */
    public function dataProviderForReverseReadArray(): array
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
     * @return array[]
     */
    public function dataProviderForReverseReadIterator(): array
    {
        $wrap = fn (array $data) => new BidirectionalIterableArrayAccessIteratorFixture($data);

        return [
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
     * @return array[]
     */
    public function dataProviderForReverseReadIteratorAggregate(): array
    {
        $wrap = fn (array $data) => new BidirectionalIterableArrayAccessFixture($data);

        return [
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
     * @dataProvider dataProviderForBidirectionalReadArray
     * @dataProvider dataProviderForBidirectionalReadIterator
     * @dataProvider dataProviderForBidirectionalReadIteratorAggregate
     * @param IterableArrayAccess $input
     * @param array $expectedKeys
     * @param array $expectedValues
     * @return void
     */
    public function testBidirectionalRead($input, array $expectedKeys, array $expectedValues): void
    {
        // Given
        $resultKeys = [];
        $resultValues = [];
        $iterator = new BidirectionalArrayAccessForwardIterator($input);

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
    public function dataProviderForBidirectionalReadArray(): array
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
     * @return array[]
     */
    public function dataProviderForBidirectionalReadIterator(): array
    {
        $wrap = fn (array $data) => new BidirectionalIterableArrayAccessIteratorFixture($data);

        return [
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
     * @return array[]
     */
    public function dataProviderForBidirectionalReadIteratorAggregate(): array
    {
        $wrap = fn (array $data) => new BidirectionalIterableArrayAccessFixture($data);

        return [
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
     * @dataProvider dataProviderForReadByIndexesArray
     * @dataProvider dataProviderForReadByIndexesIterator
     * @dataProvider dataProviderForReadByIndexesIteratorAggregate
     * @param IterableArrayAccess $input
     * @param array $expectedKeys
     * @param array $expectedValues
     * @return void
     */
    public function testReadByIndexes($input, array $expectedKeys, array $expectedValues): void
    {
        // Given
        $resultKeys = [];
        $resultValues = [];
        $iterator = new BidirectionalArrayAccessForwardIterator($input);

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
    public function dataProviderForReadByIndexesArray(): array
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
     * @return array[]
     */
    public function dataProviderForReadByIndexesIterator(): array
    {
        $wrap = fn (array $data) => new BidirectionalIterableArrayAccessIteratorFixture($data);

        return [
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
     * @return array[]
     */
    public function dataProviderForReadByIndexesIteratorAggregate(): array
    {
        $wrap = fn (array $data) => new BidirectionalIterableArrayAccessFixture($data);

        return [
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
     * @dataProvider dataProviderForNotFullBidirectionalReadArray
     * @dataProvider dataProviderForNotFullBidirectionalReadIterator
     * @dataProvider dataProviderForNotFullBidirectionalReadIteratorAggregate
     * @param IterableArrayAccess $input
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
        $iterator = new BidirectionalArrayAccessForwardIterator($input);

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
    public function dataProviderForNotFullBidirectionalReadArray(): array
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
     * @return array[]
     */
    public function dataProviderForNotFullBidirectionalReadIterator(): array
    {
        $wrap = fn (array $data) => new BidirectionalIterableArrayAccessIteratorFixture($data);

        return [
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [0, 1, 2, 3, 2, 1, 0, 4, 3, 2, 1, 0],
                [1, 2, 3, 4, 3, 2, 1, 5, 4, 3, 2, 1],
            ],
        ];
    }

    /**
     * @return array[]
     */
    public function dataProviderForNotFullBidirectionalReadIteratorAggregate(): array
    {
        $wrap = fn (array $data) => new BidirectionalIterableArrayAccessFixture($data);

        return [
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [0, 1, 2, 3, 2, 1, 0, 4, 3, 2, 1, 0],
                [1, 2, 3, 4, 3, 2, 1, 5, 4, 3, 2, 1],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForWriteArray
     * @dataProvider dataProviderForWriteIterator
     * @dataProvider dataProviderForWriteIteratorAggregate
     * @param IterableArrayAccess $input
     * @param callable $modifier
     * @param array $expectedStep1
     * @param array $expectedStep2
     * @return void
     */
    public function testWrite($input, callable $modifier, array $expectedStep1, array $expectedStep2): void
    {
        // Given
        $iterator = new BidirectionalArrayAccessForwardIterator($input);

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
    public function dataProviderForWriteArray(): array
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
     * @return array[]
     */
    public function dataProviderForWriteIterator(): array
    {
        $wrap = fn (array $data) => new BidirectionalIterableArrayAccessIteratorFixture($data);

        return [
            [
                $wrap([1, 2, 3, 4, 5]),
                fn ($value) => $value + 1,
                [2, 3, 4, 5, 6],
                [3, 4, 5, 6, 7],
            ],
        ];
    }

    /**
     * @return array[]
     */
    public function dataProviderForWriteIteratorAggregate(): array
    {
        $wrap = fn (array $data) => new BidirectionalIterableArrayAccessFixture($data);

        return [
            [
                $wrap([1, 2, 3, 4, 5]),
                fn ($value) => $value + 1,
                [2, 3, 4, 5, 6],
                [3, 4, 5, 6, 7],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForUnsetArray
     * @dataProvider dataProviderForUnsetIterator
     * @dataProvider dataProviderForUnsetIteratorAggregate
     * @param IterableArrayAccess $input
     * @param callable $predicate
     * @param array $expected
     * @return void
     */
    public function testUnset($input, callable $predicate, array $expected): void
    {
        // Given
        $iterator = new BidirectionalArrayAccessForwardIterator($input);

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
     * @dataProvider dataProviderForUnsetArray
     * @dataProvider dataProviderForUnsetIterator
     * @dataProvider dataProviderForUnsetIteratorAggregate
     * @param IterableArrayAccess $input
     * @param callable $predicate
     * @param array $expected
     * @return void
     */
    public function testUnsetReversed($input, callable $predicate, array $expected): void
    {
        // Given
        $iterator = new BidirectionalArrayAccessForwardIterator($input);
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
    public function dataProviderForUnsetArray(): array
    {
        return [
            [
                [1, 2, 3, 4, 5],
                fn ($value) => $value % 2 === 0,
                [1, 3, 5],
            ],
        ];
    }

    /**
     * @return array[]
     */
    public function dataProviderForUnsetIterator(): array
    {
        $wrap = fn (array $data) => new BidirectionalIterableArrayAccessIteratorFixture($data);

        return [
            [
                $wrap([1, 2, 3, 4, 5]),
                fn ($value) => $value % 2 === 0,
                [1, 3, 5],
            ],
        ];
    }

    /**
     * @return array[]
     */
    public function dataProviderForUnsetIteratorAggregate(): array
    {
        $wrap = fn (array $data) => new BidirectionalIterableArrayAccessFixture($data);

        return [
            [
                $wrap([1, 2, 3, 4, 5]),
                fn ($value) => $value % 2 === 0,
                [1, 3, 5],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForAddNewItemsArray
     * @dataProvider dataProviderForAddNewItemsIterator
     * @dataProvider dataProviderForAddNewItemsIteratorAggregate
     * @param IterableArrayAccess $input
     * @param array $toAdd
     * @param array $expected
     * @return void
     */
    public function testAddNewItems($input, array $toAdd, array $expected): void
    {
        // Given
        $iterator = new BidirectionalArrayAccessForwardIterator($input);
        $result = [];

        // When
        foreach ($toAdd as $item) {
            $iterator[] = $item;
        }

        // And when
        foreach ($iterator as $value) {
            $result[] = $value;
        }

        $this->assertEquals($expected, $result);
    }

    public function dataProviderForAddNewItemsArray(): array
    {
        return [
            [
                [],
                [],
                [],
            ],
            [
                [],
                [1],
                [1],
            ],
            [
                [],
                [1, 2, 3],
                [1, 2, 3],
            ],
            [
                [1],
                [2, 3, 4, 5],
                [1, 2, 3, 4, 5],
            ],
            [
                [1, 2, 3],
                [4, 5, 6],
                [1, 2, 3, 4, 5, 6],
            ],
        ];
    }

    public function dataProviderForAddNewItemsIterator(): array
    {
        $wrap = fn (array $data) => new BidirectionalIterableArrayAccessIteratorFixture($data);

        return [
            [
                $wrap([]),
                [],
                [],
            ],
            [
                $wrap([]),
                [1],
                [1],
            ],
            [
                $wrap([]),
                [1, 2, 3],
                [1, 2, 3],
            ],
            [
                $wrap([1]),
                [2, 3, 4, 5],
                [1, 2, 3, 4, 5],
            ],
            [
                $wrap([1, 2, 3]),
                [4, 5, 6],
                [1, 2, 3, 4, 5, 6],
            ],
        ];
    }

    public function dataProviderForAddNewItemsIteratorAggregate(): array
    {
        $wrap = fn (array $data) => new BidirectionalIterableArrayAccessFixture($data);

        return [
            [
                $wrap([]),
                [],
                [],
            ],
            [
                $wrap([]),
                [1],
                [1],
            ],
            [
                $wrap([]),
                [1, 2, 3],
                [1, 2, 3],
            ],
            [
                $wrap([1]),
                [2, 3, 4, 5],
                [1, 2, 3, 4, 5],
            ],
            [
                $wrap([1, 2, 3]),
                [4, 5, 6],
                [1, 2, 3, 4, 5, 6],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForAddNewItemsAssociativeArray
     * @dataProvider dataProviderForAddNewItemsAssociativeIterator
     * @dataProvider dataProviderForAddNewItemsAssociativeIteratorAggregate
     * @param IterableArrayAccess $input
     * @param array $toAdd
     * @param array $expected
     * @return void
     */
    public function testAddNewItemsAssociative($input, array $toAdd, array $expected): void
    {
        // Given
        $iterator = new BidirectionalArrayAccessForwardIterator($input);
        $result = [];

        // When
        foreach ($toAdd as $key => $item) {
            $iterator[$key] = $item;
        }

        // And when
        foreach ($iterator as $key => $value) {
            $result[$key] = $value;
        }

        $this->assertEquals($expected, $result);
    }

    public function dataProviderForAddNewItemsAssociativeArray(): array
    {
        return [
            [
                [],
                [1],
                [1],
            ],
            [
                [],
                [1 => 1],
                [1 => 1],
            ],
            [
                [],
                [1, 2, 'a' => 3],
                [1, 2, 'a' => 3],
            ],
            [
                [1],
                [2, 3, 4, 5],
                [2, 3, 4, 5],
            ],
            [
                [1],
                [1 => 2, 'a' => 3, 10 => 4],
                [1, 2, 'a' => 3, 10 => 4],
            ],
            [
                [1, -2, 3, -4],
                [1 => 2, 3 => 4, 4 => 5, 'a' => 6],
                [1, 2, 3, 4, 5, 'a' => 6],
            ],
        ];
    }

    public function dataProviderForAddNewItemsAssociativeIterator(): array
    {
        $wrap = fn (array $data) => new BidirectionalIterableArrayAccessIteratorFixture($data);

        return [
            [
                $wrap([]),
                [1],
                [1],
            ],
            [
                $wrap([]),
                [1 => 1],
                [1 => 1],
            ],
            [
                $wrap([]),
                [1, 2, 'a' => 3],
                [1, 2, 'a' => 3],
            ],
            [
                $wrap([1]),
                [2, 3, 4, 5],
                [2, 3, 4, 5],
            ],
            [
                $wrap([1]),
                [1 => 2, 'a' => 3, 10 => 4],
                [1, 2, 'a' => 3, 10 => 4],
            ],
            [
                $wrap([1, -2, 3, -4]),
                [1 => 2, 3 => 4, 4 => 5, 'a' => 6],
                [1, 2, 3, 4, 5, 'a' => 6],
            ],
        ];
    }

    public function dataProviderForAddNewItemsAssociativeIteratorAggregate(): array
    {
        $wrap = fn (array $data) => new BidirectionalIterableArrayAccessFixture($data);

        return [
            [
                $wrap([]),
                [1],
                [1],
            ],
            [
                $wrap([]),
                [1 => 1],
                [1 => 1],
            ],
            [
                $wrap([]),
                [1, 2, 'a' => 3],
                [1, 2, 'a' => 3],
            ],
            [
                $wrap([1]),
                [2, 3, 4, 5],
                [2, 3, 4, 5],
            ],
            [
                $wrap([1]),
                [1 => 2, 'a' => 3, 10 => 4],
                [1, 2, 'a' => 3, 10 => 4],
            ],
            [
                $wrap([1, -2, 3, -4]),
                [1 => 2, 3 => 4, 4 => 5, 'a' => 6],
                [1, 2, 3, 4, 5, 'a' => 6],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForUnsetForwardArray
     * @dataProvider dataProviderForUnsetForwardIterator
     * @dataProvider dataProviderForUnsetForwardIteratorAggregate
     * @param IterableArrayAccess $input
     * @param int $offset
     * @param array $keysToUnset
     * @param array $expected
     * @return void
     */
    public function testUnsetForward($input, int $offset, array $keysToUnset, array $expected): void
    {
        // Given
        $result = [];

        // When
        $iterator = new BidirectionalArrayAccessForwardIterator($input);
        $i = 0;
        for ($iterator->rewind(); $i < $offset; $iterator->next()) {
            $result[] = $iterator->current();
            ++$i;
        }

        // And when
        foreach ($keysToUnset as $key) {
            unset($iterator[$key]);
        }

        // And when
        for (; $iterator->valid(); $iterator->next()) {
            $result[] = $iterator->current();
        }

        // Then
        $this->assertEquals($expected, $result);
    }

    public function dataProviderForUnsetForwardArray(): array
    {
        return [
            [
                [1],
                1,
                [0],
                [1],
            ],
            [
                [1, 2, 3, 4, 5],
                3,
                [0],
                [1, 2, 3, 4, 5],
            ],
            [
                [1, 2, 3, 4, 5],
                3,
                [1],
                [1, 2, 3, 4, 5],
            ],
            [
                [1, 2, 3, 4, 5],
                3,
                [0, 1],
                [1, 2, 3, 4, 5],
            ],
            [
                [1, 2, 3, 4, 5],
                3,
                [0, 1, 2],
                [1, 2, 3, 4, 5],
            ],
            [
                [1, 2, 3, 4, 5],
                3,
                [0, 2],
                [1, 2, 3, 4, 5],
            ],
            [
                [1, 2, 3, 4, 5],
                3,
                [0, 2, 4],
                [1, 2, 3, 4],
            ],
            [
                [1, 2, 3, 4, 5, 6],
                3,
                [0, 2, 4],
                [1, 2, 3, 4, 6],
            ],
            [
                [1, 2, 3, 4, 5, 6],
                4,
                [0, 2, 3],
                [1, 2, 3, 4, 5, 6],
            ],
        ];
    }

    public function dataProviderForUnsetForwardIterator(): array
    {
        $wrap = fn (array $data) => new BidirectionalIterableArrayAccessIteratorFixture($data);

        return [
            [
                $wrap([1]),
                1,
                [0],
                [1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [0],
                [1, 2, 3, 4, 5],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [1],
                [1, 2, 3, 4, 5],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [0, 1],
                [1, 2, 3, 4, 5],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [0, 1, 2],
                [1, 2, 3, 4, 5],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [0, 2],
                [1, 2, 3, 4, 5],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [0, 2, 4],
                [1, 2, 3, 4],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6]),
                3,
                [0, 2, 4],
                [1, 2, 3, 4, 6],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6]),
                4,
                [0, 2, 3],
                [1, 2, 3, 4, 5, 6],
            ],
        ];
    }

    public function dataProviderForUnsetForwardIteratorAggregate(): array
    {
        $wrap = fn (array $data) => new BidirectionalIterableArrayAccessFixture($data);

        return [
            [
                $wrap([1]),
                1,
                [0],
                [1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [0],
                [1, 2, 3, 4, 5],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [1],
                [1, 2, 3, 4, 5],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [0, 1],
                [1, 2, 3, 4, 5],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [0, 1, 2],
                [1, 2, 3, 4, 5],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [0, 2],
                [1, 2, 3, 4, 5],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [0, 2, 4],
                [1, 2, 3, 4],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6]),
                3,
                [0, 2, 4],
                [1, 2, 3, 4, 6],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6]),
                4,
                [0, 2, 3],
                [1, 2, 3, 4, 5, 6],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForUnsetReverseArray
     * @dataProvider dataProviderForUnsetReverseIterator
     * @dataProvider dataProviderForUnsetReverseIteratorAggregate
     * @param IterableArrayAccess $input
     * @param int $offset
     * @param array $keysToUnset
     * @param array $expected
     * @return void
     */
    public function testUnsetReverse($input, int $offset, array $keysToUnset, array $expected): void
    {
        // Given
        $result = [];

        // When
        $iterator = new BidirectionalArrayAccessForwardIterator($input);
        $i = 0;
        for ($iterator->end(); $i < $offset; $iterator->prev()) {
            $result[] = $iterator->current();
            ++$i;
        }

        // And when
        foreach ($keysToUnset as $key) {
            unset($iterator[$key]);
        }

        // And when
        for (; $iterator->valid(); $iterator->prev()) {
            $result[] = $iterator->current();
        }

        // Then
        $this->assertEquals($expected, $result);
    }

    public function dataProviderForUnsetReverseArray(): array
    {
        return [
            [
                [1],
                1,
                [0],
                [1],
            ],
            [
                [1, 2, 3, 4, 5],
                3,
                [4],
                [5, 4, 3, 2, 1],
            ],
            [
                [1, 2, 3, 4, 5],
                3,
                [3],
                [5, 4, 3, 2, 1],
            ],
            [
                [1, 2, 3, 4, 5],
                3,
                [4, 3],
                [5, 4, 3, 2, 1],
            ],
            [
                [1, 2, 3, 4, 5],
                3,
                [4, 3, 2],
                [5, 4, 3, 2, 1],
            ],
            [
                [1, 2, 3, 4, 5],
                3,
                [2, 4],
                [5, 4, 3, 2, 1],
            ],
            [
                [1, 2, 3, 4, 5],
                3,
                [4, 2, 0],
                [5, 4, 3, 2],
            ],
            [
                [1, 2, 3, 4, 5, 6],
                3,
                [1, 3, 5],
                [6, 5, 4, 3, 1],
            ],
            [
                [1, 2, 3, 4, 5, 6],
                4,
                [5, 3, 2],
                [6, 5, 4, 3, 2, 1],
            ],
        ];
    }

    public function dataProviderForUnsetReverseIterator(): array
    {
        $wrap = fn (array $data) => new BidirectionalIterableArrayAccessIteratorFixture($data);

        return [
            [
                $wrap([1]),
                1,
                [0],
                [1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [4],
                [5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [3],
                [5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [4, 3],
                [5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [4, 3, 2],
                [5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [2, 4],
                [5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [4, 2, 0],
                [5, 4, 3, 2],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6]),
                3,
                [1, 3, 5],
                [6, 5, 4, 3, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6]),
                4,
                [5, 3, 2],
                [6, 5, 4, 3, 2, 1],
            ],
        ];
    }

    public function dataProviderForUnsetReverseIteratorAggregate(): array
    {
        $wrap = fn (array $data) => new BidirectionalIterableArrayAccessFixture($data);

        return [
            [
                $wrap([1]),
                1,
                [0],
                [1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [4],
                [5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [3],
                [5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [4, 3],
                [5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [4, 3, 2],
                [5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [2, 4],
                [5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [4, 2, 0],
                [5, 4, 3, 2],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6]),
                3,
                [1, 3, 5],
                [6, 5, 4, 3, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6]),
                4,
                [5, 3, 2],
                [6, 5, 4, 3, 2, 1],
            ],
        ];
    }
}
