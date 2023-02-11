<?php

declare(strict_types=1);

namespace IterTools\Tests\Iterators;

use IterTools\Iterators\ArrayRandomAccessReverseIterator;
use IterTools\Iterators\ArrayRandomAccessForwardIterator;
use IterTools\Stream;

class ArrayRandomAccessReverseIteratorTest extends \PHPUnit\Framework\TestCase
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
        $iterator = new ArrayRandomAccessReverseIterator($input);

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
                [null],
                [0],
                [null],
            ],
            [
                [null, null],
                [1, 0],
                [null, null],
            ],
            [
                [1, 2, 3],
                [2, 1, 0],
                [3, 2, 1],
            ],
            [
                [1, 1, 1],
                [2, 1, 0],
                [1, 1, 1],
            ],
            [
                [1, 1, 2],
                [2, 1, 0],
                [2, 1, 1],
            ],
            [
                [1.1, 2.2, 3.3],
                [2, 1, 0],
                [3.3, 2.2, 1.1],
            ],
            [
                ['1', '2', '3'],
                [2, 1, 0],
                ['3', '2', '1'],
            ],
            [
                [1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']],
                [8, 7, 6, 5, 4, 3, 2, 1, 0],
                [(object)['a', 'b', 'c'], [1, 2, 3], null, false, true, '', '3', 2.2, 1],
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
    public function testReverseReadByReverting(array $input, array $expectedKeys, array $expectedValues): void
    {
        // Given
        $resultKeys = [];
        $resultValues = [];
        $iterator = new ArrayRandomAccessReverseIterator($input);
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
     * @dataProvider dataProviderForReverseRead
     * @param array $input
     * @param array $expectedKeys
     * @param array $expectedValues
     * @return void
     */
    public function testReverseReadByUsingPrev(array $input, array $expectedKeys, array $expectedValues): void
    {
        // Given
        $resultKeys = [];
        $resultValues = [];
        $iterator = new ArrayRandomAccessReverseIterator($input);

        // When
        for ($iterator->last(); $iterator->valid(); $iterator->prev()) {
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
                [null],
                [0],
                [null],
            ],
            [
                [null, null],
                [0, 1],
                [null, null],
            ],
            [
                [1, 2, 3],
                [0, 1, 2],
                [1, 2, 3],
            ],
            [
                [1, 1, 1],
                [0, 1, 2],
                [1, 1, 1],
            ],
            [
                [1, 1, 2],
                [0, 1, 2],
                [1, 1, 2],
            ],
            [
                [1.1, 2.2, 3.3],
                [0, 1, 2],
                [1.1, 2.2, 3.3],
            ],
            [
                ['1', '2', '3'],
                [0, 1, 2],
                ['1', '2', '3'],
            ],
            [
                [1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']],
                [0, 1, 2, 3, 4, 5, 6, 7, 8],
                [1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']],
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
        $iterator = new ArrayRandomAccessReverseIterator($input);

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
                [null],
                [0, 0],
                [null, null],
            ],
            [
                [null, null],
                [1, 0, 0, 1],
                [null, null, null, null],
            ],
            [
                [1],
                [0, 0],
                [1, 1],
            ],
            [
                [1, 2, 3],
                [2, 1, 0, 0, 1, 2],
                [3, 2, 1, 1, 2, 3],
            ],
            [
                [1, 1, 1],
                [2, 1, 0, 0, 1, 2],
                [1, 1, 1, 1, 1, 1],
            ],
            [
                [1, 1, 2],
                [2, 1, 0, 0, 1, 2],
                [2, 1, 1, 1, 1, 2],
            ],
            [
                [1.1, 2.2, 3.3],
                [2, 1, 0, 0, 1, 2],
                [3.3, 2.2, 1.1, 1.1, 2.2, 3.3],
            ],
            [
                ['1', '2', '3'],
                [2, 1, 0, 0, 1, 2],
                ['3', '2', '1', '1', '2', '3'],
            ],
            [
                [1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']],
                [8, 7, 6, 5, 4, 3, 2, 1, 0, 0, 1, 2, 3, 4, 5, 6, 7, 8],
                [
                    (object)['a', 'b', 'c'], [1, 2, 3], null, false, true, '', '3', 2.2, 1,
                    1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c'],
                ],
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
        $iterator = new ArrayRandomAccessReverseIterator($input);

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
                [null],
                [0],
                [null],
            ],
            [
                [null, null],
                [0, 1],
                [null, null],
            ],
            [
                [1, 2, 3],
                [0, 1, 2],
                [1, 2, 3],
            ],
            [
                [1, 1, 1],
                [0, 1, 2],
                [1, 1, 1],
            ],
            [
                [1, 1, 2],
                [0, 1, 2],
                [1, 1, 2],
            ],
            [
                [1.1, 2.2, 3.3],
                [0, 1, 2],
                [1.1, 2.2, 3.3],
            ],
            [
                ['1', '2', '3'],
                [0, 1, 2],
                ['1', '2', '3'],
            ],
            [
                [1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']],
                [0, 1, 2, 3, 4, 5, 6, 7, 8],
                [1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']],
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
        $iterator = new ArrayRandomAccessReverseIterator($input);

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
        $iterator->last();
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
                1,
                [4, 3, 4, 0, 1, 2, 3, 4],
                [5, 4, 5, 1, 2, 3, 4, 5],
            ],
            [
                [1, 2, 3, 4, 5],
                2,
                [4, 3, 2, 3, 4, 0, 1, 2, 3, 4],
                [5, 4, 3, 4, 5, 1, 2, 3, 4, 5],
            ],
            [
                [1, 2, 3, 4, 5],
                3,
                [4, 3, 2, 1, 2, 3, 4, 0, 1, 2, 3, 4],
                [5, 4, 3, 2, 3, 4, 5, 1, 2, 3, 4, 5],
           ],
            [
                [1, 2, 3, 4, 5],
                4,
                [4, 3, 2, 1, 0, 1, 2, 3, 4, 0, 1, 2, 3, 4],
                [5, 4, 3, 2, 1, 2, 3, 4, 5, 1, 2, 3, 4, 5],
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
        $iterator = new ArrayRandomAccessReverseIterator($input);

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
        $iterator = new ArrayRandomAccessReverseIterator($input);

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
        $iterator = new ArrayRandomAccessReverseIterator($input);
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

    /**
     * @dataProvider dataProviderForAddNewItems
     * @param array $input
     * @param array $toAdd
     * @param array $expected
     * @return void
     */
    public function testAddNewItems(array $input, array $toAdd, array $expected): void
    {
        // Given
        $iterator = new ArrayRandomAccessReverseIterator($input);
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

    public function dataProviderForAddNewItems(): array
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
                [3, 2, 1],
            ],
            [
                [1],
                [2, 3, 4, 5],
                [5, 4, 3, 2, 1],
            ],
            [
                [1, 2, 3],
                [4, 5, 6],
                [6, 5, 4, 3, 2, 1],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForAddNewItemsAssociative
     * @param array $input
     * @param array $toAdd
     * @param array $expected
     * @return void
     */
    public function testAddNewItemsAssociative(array $input, array $toAdd, array $expected): void
    {
        // Given
        $iterator = new ArrayRandomAccessReverseIterator($input);
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

    public function dataProviderForAddNewItemsAssociative(): array
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

    /**
     * @dataProvider dataProviderForUnsetForward
     * @param array $input
     * @param int $offset
     * @param array $keysToUnset
     * @param array $expected
     * @return void
     */
    public function testUnsetForward(array $input, int $offset, array $keysToUnset, array $expected): void
    {
        // Given
        $result = [];

        // When
        $iterator = new ArrayRandomAccessReverseIterator($input);
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

    public function dataProviderForUnsetForward(): array
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

    /**
     * @dataProvider dataProviderForUnsetReverse
     * @param array $input
     * @param int $offset
     * @param array $keysToUnset
     * @param array $expected
     * @return void
     */
    public function testUnsetReverse(array $input, int $offset, array $keysToUnset, array $expected): void
    {
        // Given
        $result = [];

        // When
        $iterator = new ArrayRandomAccessReverseIterator($input);
        $i = 0;
        for ($iterator->last(); $i < $offset; $iterator->prev()) {
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

    public function dataProviderForUnsetReverse(): array
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

    /**
     * @dataProvider dataProviderForMovePointerForward
     * @param array $input
     * @param int $step
     * @param array $expected
     * @return void
     */
    public function testMovePointerForward(array $input, int $step, array $expected): void
    {
        // Given
        $result = [];
        $iterator = new ArrayRandomAccessReverseIterator($input);

        // When
        for ($iterator->rewind(); $iterator->valid(); $iterator->movePointer($step)) {
            $result[] = $iterator->current();
        }

        // Then
        $this->assertEquals($expected, $result);
    }

    public function dataProviderForMovePointerForward(): array
    {
        return [
            [
                [1],
                1,
                [1],
            ],
            [
                [1],
                2,
                [1],
            ],
            [
                [1],
                3,
                [1],
            ],
            [
                [1, 2, 3, 4, 5],
                1,
                [5, 4, 3, 2, 1],
            ],
            [
                [1, 2, 3, 4, 5],
                2,
                [5, 3, 1],
            ],
            [
                [1, 2, 3, 4, 5],
                3,
                [5, 2],
            ],
            [
                [1, 2, 3, 4, 5],
                4,
                [5, 1],
            ],
            [
                [1, 2, 3, 4, 5],
                5,
                [5],
            ],
            [
                [1, 2, 3, 4, 5],
                6,
                [5],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForMovePointerReverse
     * @param array $input
     * @param int $step
     * @param array $expected
     * @return void
     */
    public function testMovePointerReverse(array $input, int $step, array $expected): void
    {
        // Given
        $result = [];
        $iterator = new ArrayRandomAccessReverseIterator($input);

        // When
        for ($iterator->last(); $iterator->valid(); $iterator->movePointer(-$step)) {
            $result[] = $iterator->current();
        }

        // Then
        $this->assertEquals($expected, $result);
    }

    public function dataProviderForMovePointerReverse(): array
    {
        return [
            [
                [1],
                1,
                [1],
            ],
            [
                [1],
                2,
                [1],
            ],
            [
                [1],
                3,
                [1],
            ],
            [
                [1, 2, 3, 4, 5],
                1,
                [1, 2, 3, 4, 5],
            ],
            [
                [1, 2, 3, 4, 5],
                2,
                [1, 3, 5],
            ],
            [
                [1, 2, 3, 4, 5],
                3,
                [1, 4],
            ],
            [
                [1, 2, 3, 4, 5],
                4,
                [1, 5],
            ],
            [
                [1, 2, 3, 4, 5],
                5,
                [1],
            ],
            [
                [1, 2, 3, 4, 5],
                6,
                [1],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForIsInvalidAfterLastItem
     * @param array $input
     * @return void
     */
    public function testIsInvalidAfterLastItem(array $input): void
    {
        // Given
        $iterator = new ArrayRandomAccessReverseIterator($input);

        // When
        $iterator->last();
        $iterator->next();

        // And when
        for ($i = 0; $i < 3; ++$i) {
            $iterator->next();

            // Then
            $this->assertFalse($iterator->valid());
        }

        // Then
        $this->assertFalse($iterator->valid());
    }

    public function dataProviderForIsInvalidAfterLastItem(): array
    {
        return [
            [[]],
            [[1]],
            [[1, 2]],
            [[1, 2, 3]],
        ];
    }

    /**
     * @dataProvider dataProviderForIsInvalidBeforeFirstItem
     * @param array $input
     * @return void
     */
    public function testIsInvalidBeforeFirstItem(array $input): void
    {
        // Given
        $iterator = new ArrayRandomAccessReverseIterator($input);

        // When
        $iterator->prev();

        // Then
        $this->assertFalse($iterator->valid());

        // And when
        for ($i = 0; $i < 3; ++$i) {
            $iterator->prev();

            // Then
            $this->assertFalse($iterator->valid());
        }

        // And when
        $iterator->rewind();
        $iterator->prev();

        // Then
        $this->assertFalse($iterator->valid());
    }

    public function dataProviderForIsInvalidBeforeFirstItem(): array
    {
        return [
            [[]],
            [[1]],
            [[1, 2]],
            [[1, 2, 3]],
        ];
    }

    /**
     * @dataProvider dataProviderForReadMultipleIteratorsSimultaneously
     * @param array $input
     * @param array $expectedDirect
     * @param array $expectedReverse
     * @return void
     */
    public function testReadMultipleIteratorsSimultaneously(array $input, array $expectedDirect, array $expectedReverse): void
    {
        // Given
        $iterator1 = new ArrayRandomAccessReverseIterator($input);
        $iterator2 = new ArrayRandomAccessReverseIterator($input);
        $iterator3 = new ArrayRandomAccessForwardIterator($input);
        $iterator4 = $iterator2->reverse();
        $iterator5 = $iterator3->reverse();

        $result1 = [];
        $result2 = [];
        $result3 = [];
        $result4 = [];
        $result5 = [];

        // When
        $iterator1->rewind();
        $iterator2->rewind();
        $iterator3->rewind();
        $iterator4->rewind();
        $iterator5->rewind();

        while (true) {
            if (!$iterator1->valid() && !$iterator2->valid() && !$iterator3->valid() && !$iterator4->valid() && !$iterator5->valid()) {
                break;
            }

            $result1[] = $iterator1->current();
            $result2[] = $iterator2->current();
            $result3[] = $iterator3->current();
            $result4[] = $iterator4->current();
            $result5[] = $iterator5->current();

            $iterator1->next();
            $iterator2->next();
            $iterator3->next();
            $iterator4->next();
            $iterator5->next();
        }

        // Then
        $this->assertEquals($expectedDirect, $result1);
        $this->assertEquals($expectedDirect, $result2);
        $this->assertEquals($expectedReverse, $result3);
        $this->assertEquals($expectedReverse, $result4);
        $this->assertEquals($expectedDirect, $result5);

        // And when
        $result1 = [];
        $result2 = [];

        $iterator1 = new ArrayRandomAccessReverseIterator($input);
        $iterator2 = new ArrayRandomAccessReverseIterator($input);

        $iterator1->rewind();
        $iterator2->last();

        while (true) {
            if (!$iterator1->valid() && !$iterator2->valid()) {
                break;
            }

            $result1[] = $iterator1->current();
            $result2[] = $iterator2->current();

            $iterator1->next();
            $iterator2->prev();
        }

        // Then
        $this->assertEquals($expectedDirect, $result1);
        $this->assertEquals($expectedReverse, $result2);
    }

    public function dataProviderForReadMultipleIteratorsSimultaneously(): array
    {
        return [
            [
                [],
                [],
                [],
            ],
            [
                [1],
                [1],
                [1],
            ],
            [
                [null],
                [null],
                [null],
            ],
            [
                [null, null],
                [null, null],
                [null, null],
            ],
            [
                [1, 2, 3],
                [3, 2, 1],
                [1, 2, 3],
            ],
            [
                [1, 1, 1],
                [1, 1, 1],
                [1, 1, 1],
            ],
            [
                [1, 1, 2],
                [2, 1, 1],
                [1, 1, 2],
            ],
            [
                [1.1, 2.2, 3.3],
                [3.3, 2.2, 1.1],
                [1.1, 2.2, 3.3],
            ],
            [
                ['1', '2', '3'],
                ['3', '2', '1'],
                ['1', '2', '3'],
            ],
            [
                [1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']],
                [(object)['a', 'b', 'c'], [1, 2, 3], null, false, true, '', '3', 2.2, 1],
                [1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForCount
     * @param array $input
     * @param int $expected
     * @return void
     */
    public function testCount(array $input, int $expected): void
    {
        // When
        $iterator = new ArrayRandomAccessReverseIterator($input);

        // Then
        $this->assertCount($expected, $iterator);
    }

    public function dataProviderForCount(): array
    {
        return [
            [[], 0],
            [[1], 1],
            [[1, 2], 2],
            [[1, 2, 3], 3],
        ];
    }
}
