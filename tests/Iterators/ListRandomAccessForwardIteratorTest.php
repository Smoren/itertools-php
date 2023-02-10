<?php

declare(strict_types=1);

namespace IterTools\Tests\Iterators;

use IterTools\Iterators\ListRandomAccessForwardIterator;
use IterTools\Iterators\ListRandomAccessReverseIterator;
use IterTools\Tests\Fixture\ArrayAccessListFixture;

/**
 * @phpstan-type ArrayAccessList = \ArrayAccess<int, mixed>&\Countable
 */
class ListRandomAccessForwardIteratorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider dataProviderDirectReadArray
     * @dataProvider dataProviderDirectReadArrayAccess
     * @param array|ArrayAccessList $input
     * @param array $expectedKeys
     * @param array $expectedValues
     * @return void
     */
    public function testDirectRead($input, array $expectedKeys, array $expectedValues): void
    {
        // Given
        $resultKeys = [];
        $resultValues = [];
        $iterator = new ListRandomAccessForwardIterator($input);

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
     * @return array[]
     */
    public function dataProviderDirectReadArrayAccess(): array
    {
        $wrap = fn ($data) => new ArrayAccessListFixture($data);

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
                $wrap([null]),
                [0],
                [null],
            ],
            [
                $wrap([null, null]),
                [0, 1],
                [null, null],
            ],
            [
                $wrap([1, 2, 3]),
                [0, 1, 2],
                [1, 2, 3],
            ],
            [
                $wrap([1, 1, 1]),
                [0, 1, 2],
                [1, 1, 1],
            ],
            [
                $wrap([1, 1, 2]),
                [0, 1, 2],
                [1, 1, 2],
            ],
            [
                $wrap([1.1, 2.2, 3.3]),
                [0, 1, 2],
                [1.1, 2.2, 3.3],
            ],
            [
                $wrap(['1', '2', '3']),
                [0, 1, 2],
                ['1', '2', '3'],
            ],
            [
                $wrap([1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']]),
                [0, 1, 2, 3, 4, 5, 6, 7, 8],
                [1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForReverseReadArray
     * @dataProvider dataProviderForReverseReadArrayAccess
     * @param array|ArrayAccessList $input
     * @param array $expectedKeys
     * @param array $expectedValues
     * @return void
     */
    public function testReverseReadByReverting($input, array $expectedKeys, array $expectedValues): void
    {
        // Given
        $resultKeys = [];
        $resultValues = [];
        $iterator = new ListRandomAccessForwardIterator($input);
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
     * @dataProvider dataProviderForReverseReadArrayAccess
     * @param array|ArrayAccessList $input
     * @param array $expectedKeys
     * @param array $expectedValues
     * @return void
     */
    public function testReverseReadByUsingPrev($input, array $expectedKeys, array $expectedValues): void
    {
        // Given
        $resultKeys = [];
        $resultValues = [];
        $iterator = new ListRandomAccessForwardIterator($input);

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
     * @return array[]
     */
    public function dataProviderForReverseReadArrayAccess(): array
    {
        $wrap = fn ($data) => new ArrayAccessListFixture($data);

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
                $wrap([null]),
                [0],
                [null],
            ],
            [
                $wrap([null, null]),
                [1, 0],
                [null, null],
            ],
            [
                $wrap([1, 2, 3]),
                [2, 1, 0],
                [3, 2, 1],
            ],
            [
                $wrap([1, 1, 1]),
                [2, 1, 0],
                [1, 1, 1],
            ],
            [
                $wrap([1, 1, 2]),
                [2, 1, 0],
                [2, 1, 1],
            ],
            [
                $wrap([1.1, 2.2, 3.3]),
                [2, 1, 0],
                [3.3, 2.2, 1.1],
            ],
            [
                $wrap(['1', '2', '3']),
                [2, 1, 0],
                ['3', '2', '1'],
            ],
            [
                $wrap([1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']]),
                [8, 7, 6, 5, 4, 3, 2, 1, 0],
                [(object)['a', 'b', 'c'], [1, 2, 3], null, false, true, '', '3', 2.2, 1],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForBidirectionalReadArray
     * @dataProvider dataProviderForBidirectionalReadArrayAccess
     * @param array|ArrayAccessList $input
     * @param array $expectedKeys
     * @param array $expectedValues
     * @return void
     */
    public function testBidirectionalRead($input, array $expectedKeys, array $expectedValues): void
    {
        // Given
        $resultKeys = [];
        $resultValues = [];
        $iterator = new ListRandomAccessForwardIterator($input);

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
                [null],
                [0, 0],
                [null, null],
            ],
            [
                [null, null],
                [0, 1, 1, 0],
                [null, null, null, null],
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
                [1, 1, 1],
                [0, 1, 2, 2, 1, 0],
                [1, 1, 1, 1, 1, 1],
            ],
            [
                [1, 1, 2],
                [0, 1, 2, 2, 1, 0],
                [1, 1, 2, 2, 1, 1],
            ],
            [
                [1.1, 2.2, 3.3],
                [0, 1, 2, 2, 1, 0],
                [1.1, 2.2, 3.3, 3.3, 2.2, 1.1],
            ],
            [
                ['1', '2', '3'],
                [0, 1, 2, 2, 1, 0],
                ['1', '2', '3', '3', '2', '1'],
            ],
            [
                [1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']],
                [0, 1, 2, 3, 4, 5, 6, 7, 8, 8, 7, 6, 5, 4, 3, 2, 1, 0],
                [
                    1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c'],
                    (object)['a', 'b', 'c'], [1, 2, 3], null, false, true, '', '3', 2.2, 1,
                ],
            ],
        ];
    }

    /**
     * @return array[]
     */
    public function dataProviderForBidirectionalReadArrayAccess(): array
    {
        $wrap = fn ($data) => new ArrayAccessListFixture($data);

        return [
            [
                $wrap([]),
                [],
                [],
            ],
            [
                $wrap([null]),
                [0, 0],
                [null, null],
            ],
            [
                $wrap([null, null]),
                [0, 1, 1, 0],
                [null, null, null, null],
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
            [
                $wrap([1, 1, 1]),
                [0, 1, 2, 2, 1, 0],
                [1, 1, 1, 1, 1, 1],
            ],
            [
                $wrap([1, 1, 2]),
                [0, 1, 2, 2, 1, 0],
                [1, 1, 2, 2, 1, 1],
            ],
            [
                $wrap([1.1, 2.2, 3.3]),
                [0, 1, 2, 2, 1, 0],
                [1.1, 2.2, 3.3, 3.3, 2.2, 1.1],
            ],
            [
                $wrap(['1', '2', '3']),
                [0, 1, 2, 2, 1, 0],
                ['1', '2', '3', '3', '2', '1'],
            ],
            [
                $wrap([1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']]),
                [0, 1, 2, 3, 4, 5, 6, 7, 8, 8, 7, 6, 5, 4, 3, 2, 1, 0],
                [
                    1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c'],
                    (object)['a', 'b', 'c'], [1, 2, 3], null, false, true, '', '3', 2.2, 1,
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForReadByIndexesArray
     * @dataProvider dataProviderForReadByIndexesArrayAccess
     * @param array|ArrayAccessList $input
     * @param array $expectedKeys
     * @param array $expectedValues
     * @return void
     */
    public function testReadByIndexes($input, array $expectedKeys, array $expectedValues): void
    {
        // Given
        $resultKeys = [];
        $resultValues = [];
        $iterator = new ListRandomAccessForwardIterator($input);

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
     * @return array[]
     */
    public function dataProviderForReadByIndexesArrayAccess(): array
    {
        $wrap = fn ($data) => new ArrayAccessListFixture($data);

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
                $wrap([null]),
                [0],
                [null],
            ],
            [
                $wrap([null, null]),
                [0, 1],
                [null, null],
            ],
            [
                $wrap([1, 2, 3]),
                [0, 1, 2],
                [1, 2, 3],
            ],
            [
                $wrap([1, 1, 1]),
                [0, 1, 2],
                [1, 1, 1],
            ],
            [
                $wrap([1, 1, 2]),
                [0, 1, 2],
                [1, 1, 2],
            ],
            [
                $wrap([1.1, 2.2, 3.3]),
                [0, 1, 2],
                [1.1, 2.2, 3.3],
            ],
            [
                $wrap(['1', '2', '3']),
                [0, 1, 2],
                ['1', '2', '3'],
            ],
            [
                $wrap([1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']]),
                [0, 1, 2, 3, 4, 5, 6, 7, 8],
                [1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForNotFullBidirectionalReadArray
     * @dataProvider dataProviderForNotFullBidirectionalReadArrayAccess
     * @param array|ArrayAccessList $input
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
        $iterator = new ListRandomAccessForwardIterator($input);

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
                1,
                [0, 1, 0, 4, 3, 2, 1, 0],
                [1, 2, 1, 5, 4, 3, 2, 1],
            ],
            [
                [1, 2, 3, 4, 5],
                2,
                [0, 1, 2, 1, 0, 4, 3, 2, 1, 0],
                [1, 2, 3, 2, 1, 5, 4, 3, 2, 1],
            ],
            [
                [1, 2, 3, 4, 5],
                3,
                [0, 1, 2, 3, 2, 1, 0, 4, 3, 2, 1, 0],
                [1, 2, 3, 4, 3, 2, 1, 5, 4, 3, 2, 1],
            ],
            [
                [1, 2, 3, 4, 5],
                4,
                [0, 1, 2, 3, 4, 3, 2, 1, 0, 4, 3, 2, 1, 0],
                [1, 2, 3, 4, 5, 4, 3, 2, 1, 5, 4, 3, 2, 1],
            ],
        ];
    }

    /**
     * @return array[]
     */
    public function dataProviderForNotFullBidirectionalReadArrayAccess(): array
    {
        $wrap = fn ($data) => new ArrayAccessListFixture($data);

        return [
            [
                $wrap([1, 2, 3, 4, 5]),
                1,
                [0, 1, 0, 4, 3, 2, 1, 0],
                [1, 2, 1, 5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                2,
                [0, 1, 2, 1, 0, 4, 3, 2, 1, 0],
                [1, 2, 3, 2, 1, 5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [0, 1, 2, 3, 2, 1, 0, 4, 3, 2, 1, 0],
                [1, 2, 3, 4, 3, 2, 1, 5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                4,
                [0, 1, 2, 3, 4, 3, 2, 1, 0, 4, 3, 2, 1, 0],
                [1, 2, 3, 4, 5, 4, 3, 2, 1, 5, 4, 3, 2, 1],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForWriteArray
     * @dataProvider dataProviderForWriteArrayAccess
     * @param array|ArrayAccessList $input
     * @param callable $modifier
     * @param array $expectedStep1
     * @param array $expectedStep2
     * @return void
     */
    public function testWrite($input, callable $modifier, array $expectedStep1, array $expectedStep2): void
    {
        // Given
        $iterator = new ListRandomAccessForwardIterator($input);

        // When
        foreach ($iterator as $key => $value) {
            $iterator[$key] = $modifier($value);
        }
        $actual = ($input instanceof ArrayAccessListFixture)
            ? $input->toArray()
            : $input;

        // Then
        $this->assertEquals($expectedStep1, $actual);

        // And when
        $iterator = $iterator->reverse();
        foreach ($iterator as $key => $value) {
            $iterator[$key] = $modifier($value);
        }
        $actual = ($input instanceof ArrayAccessListFixture)
            ? $input->toArray()
            : $input;

        // Then
        $this->assertEquals($expectedStep2, $actual);
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
    public function dataProviderForWriteArrayAccess(): array
    {
        $wrap = fn ($data) => new ArrayAccessListFixture($data);

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
     * @dataProvider dataProviderForAddNewItemsArray
     * @dataProvider dataProviderForAddNewItemsArrayAccess
     * @param array|ArrayAccessList $input
     * @param array $toAdd
     * @param array $expected
     * @return void
     */
    public function testAddNewItems($input, array $toAdd, array $expected): void
    {
        // Given
        $iterator = new ListRandomAccessForwardIterator($input);
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

    public function dataProviderForAddNewItemsArrayAccess(): array
    {
        $wrap = fn ($data) => new ArrayAccessListFixture($data);

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
     * @dataProvider dataProviderForMovePointerForwardArray
     * @dataProvider dataProviderForMovePointerForwardArrayAccess
     * @param array|ArrayAccessList $input
     * @param int $step
     * @param array $expected
     * @return void
     */
    public function testMovePointerForward($input, int $step, array $expected): void
    {
        // Given
        $result = [];
        $iterator = new ListRandomAccessForwardIterator($input);

        // When
        for ($iterator->rewind(); $iterator->valid(); $iterator->movePointer($step)) {
            $result[] = $iterator->current();
        }

        // Then
        $this->assertEquals($expected, $result);
    }

    public function dataProviderForMovePointerForwardArray(): array
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

    public function dataProviderForMovePointerForwardArrayAccess(): array
    {
        $wrap = fn ($data) => new ArrayAccessListFixture($data);

        return [
            [
                $wrap([1]),
                1,
                [1],
            ],
            [
                $wrap([1]),
                2,
                [1],
            ],
            [
                $wrap([1]),
                3,
                [1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                1,
                [1, 2, 3, 4, 5],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                2,
                [1, 3, 5],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [1, 4],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                4,
                [1, 5],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                5,
                [1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                6,
                [1],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForMovePointerReverseArray
     * @dataProvider dataProviderForMovePointerReverseArrayAccess
     * @param array|ArrayAccessList $input
     * @param int $step
     * @param array $expected
     * @return void
     */
    public function testMovePointerReverse($input, int $step, array $expected): void
    {
        // Given
        $result = [];
        $iterator = new ListRandomAccessForwardIterator($input);

        // When
        for ($iterator->end(); $iterator->valid(); $iterator->movePointer(-$step)) {
            $result[] = $iterator->current();
        }

        // Then
        $this->assertEquals($expected, $result);
    }

    public function dataProviderForMovePointerReverseArray(): array
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

    public function dataProviderForMovePointerReverseArrayAccess(): array
    {
        $wrap = fn ($data) => new ArrayAccessListFixture($data);

        return [
            [
                $wrap([1]),
                1,
                [1],
            ],
            [
                $wrap([1]),
                2,
                [1],
            ],
            [
                $wrap([1]),
                3,
                [1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                1,
                [5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                2,
                [5, 3, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                3,
                [5, 2],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                4,
                [5, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                5,
                [5],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                6,
                [5],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForIsInvalidAfterLastItemArray
     * @dataProvider dataProviderForIsInvalidAfterLastItemArrayAccess
     * @param array|ArrayAccessList $input
     * @return void
     */
    public function testIsInvalidAfterLastItem($input): void
    {
        // Given
        $iterator = new ListRandomAccessForwardIterator($input);

        // When
        $iterator->end();
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

    public function dataProviderForIsInvalidAfterLastItemArray(): array
    {
        return [
            [[]],
            [[1]],
            [[1, 2]],
            [[1, 2, 3]],
        ];
    }

    public function dataProviderForIsInvalidAfterLastItemArrayAccess(): array
    {
        $wrap = fn ($data) => new ArrayAccessListFixture($data);

        return [
            [$wrap([])],
            [$wrap([1])],
            [$wrap([1, 2])],
            [$wrap([1, 2, 3])],
        ];
    }

    /**
     * @dataProvider dataProviderForIsInvalidBeforeFirstItemArray
     * @dataProvider dataProviderForIsInvalidBeforeFirstItemArrayAccess
     * @param array|ArrayAccessList $input
     * @return void
     */
    public function testIsInvalidBeforeFirstItem($input): void
    {
        // Given
        $iterator = new ListRandomAccessForwardIterator($input);

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

    public function dataProviderForIsInvalidBeforeFirstItemArray(): array
    {
        return [
            [[]],
            [[1]],
            [[1, 2]],
            [[1, 2, 3]],
        ];
    }

    public function dataProviderForIsInvalidBeforeFirstItemArrayAccess(): array
    {
        $wrap = fn ($data) => new ArrayAccessListFixture($data);

        return [
            [$wrap([])],
            [$wrap([1])],
            [$wrap([1, 2])],
            [$wrap([1, 2, 3])],
        ];
    }

    /**
     * @dataProvider dataProviderForReadMultipleIteratorsSimultaneouslyArray
     * @dataProvider dataProviderForReadMultipleIteratorsSimultaneouslyArrayAccess
     * @param array|ArrayAccessList $input
     * @param array $expectedDirect
     * @param array $expectedReverse
     * @return void
     */
    public function testReadMultipleIteratorsSimultaneously($input, array $expectedDirect, array $expectedReverse): void
    {
        // Given
        $iterator1 = new ListRandomAccessForwardIterator($input);
        $iterator2 = new ListRandomAccessForwardIterator($input);
        $iterator3 = new ListRandomAccessReverseIterator($input);
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

        $iterator1 = new ListRandomAccessForwardIterator($input);
        $iterator2 = new ListRandomAccessForwardIterator($input);

        $iterator1->rewind();
        $iterator2->end();

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

    public function dataProviderForReadMultipleIteratorsSimultaneouslyArray(): array
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
                [1, 2, 3],
                [3, 2, 1],
            ],
            [
                [1, 1, 1],
                [1, 1, 1],
                [1, 1, 1],
            ],
            [
                [1, 1, 2],
                [1, 1, 2],
                [2, 1, 1],
            ],
            [
                [1.1, 2.2, 3.3],
                [1.1, 2.2, 3.3],
                [3.3, 2.2, 1.1],
            ],
            [
                ['1', '2', '3'],
                ['1', '2', '3'],
                ['3', '2', '1'],
            ],
            [
                [1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']],
                [1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']],
                [(object)['a', 'b', 'c'], [1, 2, 3], null, false, true, '', '3', 2.2, 1],
            ],
        ];
    }

    public function dataProviderForReadMultipleIteratorsSimultaneouslyArrayAccess(): array
    {
        $wrap = fn ($data) => new ArrayAccessListFixture($data);

        return [
            [
                $wrap([]),
                [],
                [],
            ],
            [
                $wrap([1]),
                [1],
                [1],
            ],
            [
                $wrap([null]),
                [null],
                [null],
            ],
            [
                $wrap([null, null]),
                [null, null],
                [null, null],
            ],
            [
                $wrap([1, 2, 3]),
                [1, 2, 3],
                [3, 2, 1],
            ],
            [
                $wrap([1, 1, 1]),
                [1, 1, 1],
                [1, 1, 1],
            ],
            [
                $wrap([1, 1, 2]),
                [1, 1, 2],
                [2, 1, 1],
            ],
            [
                $wrap([1.1, 2.2, 3.3]),
                [1.1, 2.2, 3.3],
                [3.3, 2.2, 1.1],
            ],
            [
                $wrap(['1', '2', '3']),
                ['1', '2', '3'],
                ['3', '2', '1'],
            ],
            [
                $wrap([1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']]),
                [1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']],
                [(object)['a', 'b', 'c'], [1, 2, 3], null, false, true, '', '3', 2.2, 1],
            ],
        ];
    }
}
