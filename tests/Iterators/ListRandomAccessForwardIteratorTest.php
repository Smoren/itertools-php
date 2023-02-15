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
     * @param array $config
     * @param array $expectedKeys
     * @param array $expectedValues
     * @return void
     */
    public function testDirectRead($input, array $config, array $expectedKeys, array $expectedValues): void
    {
        // Given
        $resultKeys = [];
        $resultValues = [];
        $iterator = new ListRandomAccessForwardIterator($input, ...$config);

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
                [],
            ],
            [
                [1],
                [],
                [0],
                [1],
            ],
            [
                [null],
                [],
                [0],
                [null],
            ],
            [
                [null, null],
                [],
                [0, 1],
                [null, null],
            ],
            [
                [1, 2, 3],
                [],
                [0, 1, 2],
                [1, 2, 3],
            ],
            [
                [1, 1, 1],
                [],
                [0, 1, 2],
                [1, 1, 1],
            ],
            [
                [1, 1, 2],
                [],
                [0, 1, 2],
                [1, 1, 2],
            ],
            [
                [1.1, 2.2, 3.3],
                [],
                [0, 1, 2],
                [1.1, 2.2, 3.3],
            ],
            [
                ['1', '2', '3'],
                [],
                [0, 1, 2],
                ['1', '2', '3'],
            ],
            [
                [1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']],
                [],
                [0, 1, 2, 3, 4, 5, 6, 7, 8],
                [1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 9],
                [0, 1, 2, 3, 4, 5, 6, 7, 8],
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 8],
                [0, 1, 2, 3, 4, 5, 6, 7],
                [1, 2, 3, 4, 5, 6, 7, 8],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 2],
                [0, 1],
                [1, 2],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 1],
                [0],
                [1],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 0],
                [],
                [],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [9, 9],
                [],
                [],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [8, 9],
                [0],
                [9],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [7, 9],
                [0, 1],
                [8, 9],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [3, 5],
                [0, 1],
                [4, 5],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [3, 4],
                [0],
                [4],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [3, 3],
                [],
                [],
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
                [],
            ],
            [
                $wrap([1]),
                [],
                [0],
                [1],
            ],
            [
                $wrap([null]),
                [],
                [0],
                [null],
            ],
            [
                $wrap([null, null]),
                [],
                [0, 1],
                [null, null],
            ],
            [
                $wrap([1, 2, 3]),
                [],
                [0, 1, 2],
                [1, 2, 3],
            ],
            [
                $wrap([1, 1, 1]),
                [],
                [0, 1, 2],
                [1, 1, 1],
            ],
            [
                $wrap([1, 1, 2]),
                [],
                [0, 1, 2],
                [1, 1, 2],
            ],
            [
                $wrap([1.1, 2.2, 3.3]),
                [],
                [0, 1, 2],
                [1.1, 2.2, 3.3],
            ],
            [
                $wrap(['1', '2', '3']),
                [],
                [0, 1, 2],
                ['1', '2', '3'],
            ],
            [
                $wrap([1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']]),
                [],
                [0, 1, 2, 3, 4, 5, 6, 7, 8],
                [1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 9],
                [0, 1, 2, 3, 4, 5, 6, 7, 8],
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 8],
                [0, 1, 2, 3, 4, 5, 6, 7],
                [1, 2, 3, 4, 5, 6, 7, 8],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 2],
                [0, 1],
                [1, 2],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 1],
                [0],
                [1],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 0],
                [],
                [],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [9, 9],
                [],
                [],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [8, 9],
                [0],
                [9],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [7, 9],
                [0, 1],
                [8, 9],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [3, 5],
                [0, 1],
                [4, 5],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [3, 4],
                [0],
                [4],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [3, 3],
                [],
                [],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForReverseReadByRevertingArray
     * @dataProvider dataProviderForReverseReadByRevertingArrayAccess
     * @param array|ArrayAccessList $input
     * @param array $config
     * @param array $expectedKeys
     * @param array $expectedValues
     * @return void
     */
    public function testReverseReadByReverting($input, array $config, array $expectedKeys, array $expectedValues): void
    {
        // Given
        $resultKeys = [];
        $resultValues = [];
        $iterator = new ListRandomAccessForwardIterator($input, ...$config);
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
    public function dataProviderForReverseReadByRevertingArray(): array
    {
        return [
            [
                [],
                [],
                [],
                [],
            ],
            [
                [1],
                [],
                [0],
                [1],
            ],
            [
                [null],
                [],
                [0],
                [null],
            ],
            [
                [null, null],
                [],
                [0, 1],
                [null, null],
            ],
            [
                [1, 2, 3],
                [],
                [0, 1, 2],
                [3, 2, 1],
            ],
            [
                [1, 1, 1],
                [],
                [0, 1, 2],
                [1, 1, 1],
            ],
            [
                [1, 1, 2],
                [],
                [0, 1, 2],
                [2, 1, 1],
            ],
            [
                [1.1, 2.2, 3.3],
                [],
                [0, 1, 2],
                [3.3, 2.2, 1.1],
            ],
            [
                ['1', '2', '3'],
                [],
                [0, 1, 2],
                ['3', '2', '1'],
            ],
            [
                [1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']],
                [],
                [0, 1, 2, 3, 4, 5, 6, 7, 8],
                [(object)['a', 'b', 'c'], [1, 2, 3], null, false, true, '', '3', 2.2, 1],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 9],
                [0, 1, 2, 3, 4, 5, 6, 7, 8],
                [9, 8, 7, 6, 5, 4, 3, 2, 1],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 8],
                [0, 1, 2, 3, 4, 5, 6, 7],
                [8, 7, 6, 5, 4, 3, 2, 1],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 2],
                [0, 1],
                [2, 1],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 1],
                [0],
                [1],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 0],
                [],
                [],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [9, 9],
                [],
                [],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [8, 9],
                [0],
                [9],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [7, 9],
                [0, 1],
                [9, 8],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [3, 5],
                [0, 1],
                [5, 4],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [3, 4],
                [0],
                [4],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [3, 3],
                [],
                [],
            ],
        ];
    }

    /**
     * @return array[]
     */
    public function dataProviderForReverseReadByRevertingArrayAccess(): array
    {
        $wrap = fn ($data) => new ArrayAccessListFixture($data);

        return [
            [
                $wrap([]),
                [],
                [],
                [],
            ],
            [
                $wrap([1]),
                [],
                [0],
                [1],
            ],
            [
                $wrap([null]),
                [],
                [0],
                [null],
            ],
            [
                $wrap([null, null]),
                [],
                [0, 1],
                [null, null],
            ],
            [
                $wrap([1, 2, 3]),
                [],
                [0, 1, 2],
                [3, 2, 1],
            ],
            [
                $wrap([1, 1, 1]),
                [],
                [0, 1, 2],
                [1, 1, 1],
            ],
            [
                $wrap([1, 1, 2]),
                [],
                [0, 1, 2],
                [2, 1, 1],
            ],
            [
                $wrap([1.1, 2.2, 3.3]),
                [],
                [0, 1, 2],
                [3.3, 2.2, 1.1],
            ],
            [
                $wrap(['1', '2', '3']),
                [],
                [0, 1, 2],
                ['3', '2', '1'],
            ],
            [
                $wrap([1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']]),
                [],
                [0, 1, 2, 3, 4, 5, 6, 7, 8],
                [(object)['a', 'b', 'c'], [1, 2, 3], null, false, true, '', '3', 2.2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 9],
                [0, 1, 2, 3, 4, 5, 6, 7, 8],
                [9, 8, 7, 6, 5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 8],
                [0, 1, 2, 3, 4, 5, 6, 7],
                [8, 7, 6, 5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 2],
                [0, 1],
                [2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 1],
                [0],
                [1],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 0],
                [],
                [],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [9, 9],
                [],
                [],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [8, 9],
                [0],
                [9],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [7, 9],
                [0, 1],
                [9, 8],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [3, 5],
                [0, 1],
                [5, 4],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [3, 4],
                [0],
                [4],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [3, 3],
                [],
                [],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForReverseReadByUsingPrevArray
     * @dataProvider dataProviderForReverseReadByUsingPrevArrayAccess
     * @param array|ArrayAccessList $input
     * @param array $config
     * @param array $expectedKeys
     * @param array $expectedValues
     * @return void
     */
    public function testReverseReadByUsingPrev($input, array $config, array $expectedKeys, array $expectedValues): void
    {
        // Given
        $resultKeys = [];
        $resultValues = [];
        $iterator = new ListRandomAccessForwardIterator($input, ...$config);

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
    public function dataProviderForReverseReadByUsingPrevArray(): array
    {
        return [
            [
                [],
                [],
                [],
                [],
            ],
            [
                [1],
                [],
                [0],
                [1],
            ],
            [
                [null],
                [],
                [0],
                [null],
            ],
            [
                [null, null],
                [],
                [1, 0],
                [null, null],
            ],
            [
                [1, 2, 3],
                [],
                [2, 1, 0],
                [3, 2, 1],
            ],
            [
                [1, 1, 1],
                [],
                [2, 1, 0],
                [1, 1, 1],
            ],
            [
                [1, 1, 2],
                [],
                [2, 1, 0],
                [2, 1, 1],
            ],
            [
                [1.1, 2.2, 3.3],
                [],
                [2, 1, 0],
                [3.3, 2.2, 1.1],
            ],
            [
                ['1', '2', '3'],
                [],
                [2, 1, 0],
                ['3', '2', '1'],
            ],
            [
                [1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']],
                [],
                [8, 7, 6, 5, 4, 3, 2, 1, 0],
                [(object)['a', 'b', 'c'], [1, 2, 3], null, false, true, '', '3', 2.2, 1],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 9],
                [8, 7, 6, 5, 4, 3, 2, 1, 0],
                [9, 8, 7, 6, 5, 4, 3, 2, 1],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 8],
                [7, 6, 5, 4, 3, 2, 1, 0],
                [8, 7, 6, 5, 4, 3, 2, 1],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 2],
                [1, 0],
                [2, 1],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 1],
                [0],
                [1],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 0],
                [],
                [],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [9, 9],
                [],
                [],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [8, 9],
                [0],
                [9],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [7, 9],
                [1, 0],
                [9, 8],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [3, 5],
                [1, 0],
                [5, 4],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [3, 4],
                [0],
                [4],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [3, 3],
                [],
                [],
            ],
        ];
    }

    /**
     * @return array[]
     */
    public function dataProviderForReverseReadByUsingPrevArrayAccess(): array
    {
        $wrap = fn ($data) => new ArrayAccessListFixture($data);

        return [
            [
                $wrap([]),
                [],
                [],
                [],
            ],
            [
                $wrap([1]),
            [],
                [0],
                [1],
            ],
            [
                $wrap([null]),
                [],
                [0],
                [null],
            ],
            [
                $wrap([null, null]),
                [],
                [1, 0],
                [null, null],
            ],
            [
                $wrap([1, 2, 3]),
                [],
                [2, 1, 0],
                [3, 2, 1],
            ],
            [
                $wrap([1, 1, 1]),
                [],
                [2, 1, 0],
                [1, 1, 1],
            ],
            [
                $wrap([1, 1, 2]),
                [],
                [2, 1, 0],
                [2, 1, 1],
            ],
            [
                $wrap([1.1, 2.2, 3.3]),
                [],
                [2, 1, 0],
                [3.3, 2.2, 1.1],
            ],
            [
                $wrap(['1', '2', '3']),
                [],
                [2, 1, 0],
                ['3', '2', '1'],
            ],
            [
                $wrap([1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']]),
                [],
                [8, 7, 6, 5, 4, 3, 2, 1, 0],
                [(object)['a', 'b', 'c'], [1, 2, 3], null, false, true, '', '3', 2.2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 9],
                [8, 7, 6, 5, 4, 3, 2, 1, 0],
                [9, 8, 7, 6, 5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 8],
                [7, 6, 5, 4, 3, 2, 1, 0],
                [8, 7, 6, 5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 2],
                [1, 0],
                [2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 1],
                [0],
                [1],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 0],
                [],
                [],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [9, 9],
                [],
                [],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [8, 9],
                [0],
                [9],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [7, 9],
                [1, 0],
                [9, 8],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [3, 5],
                [1, 0],
                [5, 4],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [3, 4],
                [0],
                [4],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [3, 3],
                [],
                [],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForBidirectionalReadUsingRevertingArray
     * @dataProvider dataProviderForBidirectionalReadUsingRevertingArrayAccess
     * @param array|ArrayAccessList $input
     * @param array $config
     * @param array $expectedKeys
     * @param array $expectedValues
     * @return void
     */
    public function testBidirectionalReadUsingReverting($input, array $config, array $expectedKeys, array $expectedValues): void
    {
        // Given
        $resultKeys = [];
        $resultValues = [];
        $iterator = new ListRandomAccessForwardIterator($input, ...$config);

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
    public function dataProviderForBidirectionalReadUsingRevertingArray(): array
    {
        return [
            [
                [],
                [],
                [],
                [],
            ],
            [
                [null],
                [],
                [0, 0],
                [null, null],
            ],
            [
                [null, null],
                [],
                [0, 1, 0, 1],
                [null, null, null, null],
            ],
            [
                [1],
                [],
                [0, 0],
                [1, 1],
            ],
            [
                [1, 2, 3],
                [],
                [0, 1, 2, 0, 1, 2],
                [1, 2, 3, 3, 2, 1],
            ],
            [
                [1, 1, 1],
                [],
                [0, 1, 2, 0, 1, 2],
                [1, 1, 1, 1, 1, 1],
            ],
            [
                [1, 1, 2],
                [],
                [0, 1, 2, 0, 1, 2],
                [1, 1, 2, 2, 1, 1],
            ],
            [
                [1.1, 2.2, 3.3],
                [],
                [0, 1, 2, 0, 1, 2],
                [1.1, 2.2, 3.3, 3.3, 2.2, 1.1],
            ],
            [
                ['1', '2', '3'],
                [],
                [0, 1, 2, 0, 1, 2],
                ['1', '2', '3', '3', '2', '1'],
            ],
            [
                [1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']],
                [],
                [0, 1, 2, 3, 4, 5, 6, 7, 8, 0, 1, 2, 3, 4, 5, 6, 7, 8],
                [
                    1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c'],
                    (object)['a', 'b', 'c'], [1, 2, 3], null, false, true, '', '3', 2.2, 1,
                ],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 9],
                [0, 1, 2, 3, 4, 5, 6, 7, 8, 0, 1, 2, 3, 4, 5, 6, 7, 8],
                [1, 2, 3, 4, 5, 6, 7, 8, 9, 9, 8, 7, 6, 5, 4, 3, 2, 1],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 8],
                [0, 1, 2, 3, 4, 5, 6, 7, 0, 1, 2, 3, 4, 5, 6, 7],
                [1, 2, 3, 4, 5, 6, 7, 8, 8, 7, 6, 5, 4, 3, 2, 1],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 2],
                [0, 1, 0, 1],
                [1, 2, 2, 1],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 1],
                [0, 0],
                [1, 1],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 0],
                [],
                [],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [9, 9],
                [],
                [],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [8, 9],
                [0, 0],
                [9, 9],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [7, 9],
                [0, 1, 0, 1],
                [8, 9, 9, 8],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [3, 5],
                [0, 1, 0, 1],
                [4, 5, 5, 4],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [3, 4],
                [0, 0],
                [4, 4],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [3, 3],
                [],
                [],
            ],
        ];
    }

    /**
     * @return array[]
     */
    public function dataProviderForBidirectionalReadUsingRevertingArrayAccess(): array
    {
        $wrap = fn ($data) => new ArrayAccessListFixture($data);

        return [
            [
                $wrap([]),
                [],
                [],
                [],
            ],
            [
                $wrap([null]),
                [],
                [0, 0],
                [null, null],
            ],
            [
                $wrap([null, null]),
                [],
                [0, 1, 0, 1],
                [null, null, null, null],
            ],
            [
                $wrap([1]),
                [],
                [0, 0],
                [1, 1],
            ],
            [
                $wrap([1, 2, 3]),
                [],
                [0, 1, 2, 0, 1, 2],
                [1, 2, 3, 3, 2, 1],
            ],
            [
                $wrap([1, 1, 1]),
                [],
                [0, 1, 2, 0, 1, 2],
                [1, 1, 1, 1, 1, 1],
            ],
            [
                $wrap([1, 1, 2]),
                [],
                [0, 1, 2, 0, 1, 2],
                [1, 1, 2, 2, 1, 1],
            ],
            [
                $wrap([1.1, 2.2, 3.3]),
                [],
                [0, 1, 2, 0, 1, 2],
                [1.1, 2.2, 3.3, 3.3, 2.2, 1.1],
            ],
            [
                $wrap(['1', '2', '3']),
                [],
                [0, 1, 2, 0, 1, 2],
                ['1', '2', '3', '3', '2', '1'],
            ],
            [
                $wrap([1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']]),
                [],
                [0, 1, 2, 3, 4, 5, 6, 7, 8, 0, 1, 2, 3, 4, 5, 6, 7, 8],
                [
                    1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c'],
                    (object)['a', 'b', 'c'], [1, 2, 3], null, false, true, '', '3', 2.2, 1,
                ],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 9],
                [0, 1, 2, 3, 4, 5, 6, 7, 8, 0, 1, 2, 3, 4, 5, 6, 7, 8],
                [1, 2, 3, 4, 5, 6, 7, 8, 9, 9, 8, 7, 6, 5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 8],
                [0, 1, 2, 3, 4, 5, 6, 7, 0, 1, 2, 3, 4, 5, 6, 7],
                [1, 2, 3, 4, 5, 6, 7, 8, 8, 7, 6, 5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 2],
                [0, 1, 0, 1],
                [1, 2, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 1],
                [0, 0],
                [1, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 0],
                [],
                [],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [9, 9],
                [],
                [],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [8, 9],
                [0, 0],
                [9, 9],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [7, 9],
                [0, 1, 0, 1],
                [8, 9, 9, 8],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [3, 5],
                [0, 1, 0, 1],
                [4, 5, 5, 4],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [3, 4],
                [0, 0],
                [4, 4],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [3, 3],
                [],
                [],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForBidirectionalReadUsingPrevArray
     * @dataProvider dataProviderForBidirectionalReadUsingPrevArrayAccess
     * @param array|ArrayAccessList $input
     * @param array $config
     * @param array $expectedKeys
     * @param array $expectedValues
     * @return void
     */
    public function testBidirectionalReadUsingPrev($input, array $config, array $expectedKeys, array $expectedValues): void
    {
        // Given
        $resultKeys = [];
        $resultValues = [];
        $iterator = new ListRandomAccessForwardIterator($input, ...$config);

        // When
        foreach ($iterator as $key => $value) {
            $resultKeys[] = $key;
            $resultValues[] = $value;
        }

        // And when
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
    public function dataProviderForBidirectionalReadUsingPrevArray(): array
    {
        return [
            [
                [],
                [],
                [],
                [],
            ],
            [
                [null],
                [],
                [0, 0],
                [null, null],
            ],
            [
                [null, null],
                [],
                [0, 1, 1, 0],
                [null, null, null, null],
            ],
            [
                [1],
                [],
                [0, 0],
                [1, 1],
            ],
            [
                [1, 2, 3],
                [],
                [0, 1, 2, 2, 1, 0],
                [1, 2, 3, 3, 2, 1],
            ],
            [
                [1, 1, 1],
                [],
                [0, 1, 2, 2, 1, 0],
                [1, 1, 1, 1, 1, 1],
            ],
            [
                [1, 1, 2],
                [],
                [0, 1, 2, 2, 1, 0],
                [1, 1, 2, 2, 1, 1],
            ],
            [
                [1.1, 2.2, 3.3],
                [],
                [0, 1, 2, 2, 1, 0],
                [1.1, 2.2, 3.3, 3.3, 2.2, 1.1],
            ],
            [
                ['1', '2', '3'],
                [],
                [0, 1, 2, 2, 1, 0],
                ['1', '2', '3', '3', '2', '1'],
            ],
            [
                [1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']],
                [],
                [0, 1, 2, 3, 4, 5, 6, 7, 8, 8, 7, 6, 5, 4, 3, 2, 1, 0],
                [
                    1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c'],
                    (object)['a', 'b', 'c'], [1, 2, 3], null, false, true, '', '3', 2.2, 1,
                ],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 9],
                [0, 1, 2, 3, 4, 5, 6, 7, 8, 8, 7, 6, 5, 4, 3, 2, 1, 0],
                [1, 2, 3, 4, 5, 6, 7, 8, 9, 9, 8, 7, 6, 5, 4, 3, 2, 1],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 8],
                [0, 1, 2, 3, 4, 5, 6, 7, 7, 6, 5, 4, 3, 2, 1, 0],
                [1, 2, 3, 4, 5, 6, 7, 8, 8, 7, 6, 5, 4, 3, 2, 1],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 2],
                [0, 1, 1, 0],
                [1, 2, 2, 1],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 1],
                [0, 0],
                [1, 1],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 0],
                [],
                [],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [9, 9],
                [],
                [],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [8, 9],
                [0, 0],
                [9, 9],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [7, 9],
                [0, 1, 1, 0],
                [8, 9, 9, 8],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [3, 5],
                [0, 1, 1, 0],
                [4, 5, 5, 4],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [3, 4],
                [0, 0],
                [4, 4],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [3, 3],
                [],
                [],
            ],
        ];
    }

    /**
     * @return array[]
     */
    public function dataProviderForBidirectionalReadUsingPrevArrayAccess(): array
    {
        $wrap = fn ($data) => new ArrayAccessListFixture($data);

        return [
            [
                $wrap([]),
                [],
                [],
                [],
            ],
            [
                $wrap([null]),
                [],
                [0, 0],
                [null, null],
            ],
            [
                $wrap([null, null]),
                [],
                [0, 1, 1, 0],
                [null, null, null, null],
            ],
            [
                $wrap([1]),
                [],
                [0, 0],
                [1, 1],
            ],
            [
                $wrap([1, 2, 3]),
                [],
                [0, 1, 2, 2, 1, 0],
                [1, 2, 3, 3, 2, 1],
            ],
            [
                $wrap([1, 1, 1]),
                [],
                [0, 1, 2, 2, 1, 0],
                [1, 1, 1, 1, 1, 1],
            ],
            [
                $wrap([1, 1, 2]),
                [],
                [0, 1, 2, 2, 1, 0],
                [1, 1, 2, 2, 1, 1],
            ],
            [
                $wrap([1.1, 2.2, 3.3]),
                [],
                [0, 1, 2, 2, 1, 0],
                [1.1, 2.2, 3.3, 3.3, 2.2, 1.1],
            ],
            [
                $wrap(['1', '2', '3']),
                [],
                [0, 1, 2, 2, 1, 0],
                ['1', '2', '3', '3', '2', '1'],
            ],
            [
                $wrap([1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']]),
                [],
                [0, 1, 2, 3, 4, 5, 6, 7, 8, 8, 7, 6, 5, 4, 3, 2, 1, 0],
                [
                    1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c'],
                    (object)['a', 'b', 'c'], [1, 2, 3], null, false, true, '', '3', 2.2, 1,
                ],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 9],
                [0, 1, 2, 3, 4, 5, 6, 7, 8, 8, 7, 6, 5, 4, 3, 2, 1, 0],
                [1, 2, 3, 4, 5, 6, 7, 8, 9, 9, 8, 7, 6, 5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 8],
                [0, 1, 2, 3, 4, 5, 6, 7, 7, 6, 5, 4, 3, 2, 1, 0],
                [1, 2, 3, 4, 5, 6, 7, 8, 8, 7, 6, 5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 2],
                [0, 1, 1, 0],
                [1, 2, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 1],
                [0, 0],
                [1, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 0],
                [],
                [],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [9, 9],
                [],
                [],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [8, 9],
                [0, 0],
                [9, 9],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [7, 9],
                [0, 1, 1, 0],
                [8, 9, 9, 8],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [3, 5],
                [0, 1, 1, 0],
                [4, 5, 5, 4],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [3, 4],
                [0, 0],
                [4, 4],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [3, 3],
                [],
                [],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForReadByIndexesArray
     * @dataProvider dataProviderForReadByIndexesArrayAccess
     * @param array|ArrayAccessList $input
     * @param array $config
     * @param array $expectedKeys
     * @param array $expectedValues
     * @return void
     */
    public function testReadByIndexes($input, array $config, array $expectedKeys, array $expectedValues): void
    {
        // Given
        $resultKeys = [];
        $resultValues = [];
        $iterator = new ListRandomAccessForwardIterator($input, ...$config);

        // When
        for ($i=0; $i<count($iterator); ++$i) {
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
                [],
            ],
            [
                [1],
                [],
                [0],
                [1],
            ],
            [
                [null],
                [],
                [0],
                [null],
            ],
            [
                [null, null],
                [],
                [0, 1],
                [null, null],
            ],
            [
                [1, 2, 3],
                [],
                [0, 1, 2],
                [1, 2, 3],
            ],
            [
                [1, 1, 1],
                [],
                [0, 1, 2],
                [1, 1, 1],
            ],
            [
                [1, 1, 2],
                [],
                [0, 1, 2],
                [1, 1, 2],
            ],
            [
                [1.1, 2.2, 3.3],
                [],
                [0, 1, 2],
                [1.1, 2.2, 3.3],
            ],
            [
                ['1', '2', '3'],
                [],
                [0, 1, 2],
                ['1', '2', '3'],
            ],
            [
                [1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']],
                [],
                [0, 1, 2, 3, 4, 5, 6, 7, 8],
                [1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 9],
                [0, 1, 2, 3, 4, 5, 6, 7, 8],
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 8],
                [0, 1, 2, 3, 4, 5, 6, 7],
                [1, 2, 3, 4, 5, 6, 7, 8],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 2],
                [0, 1],
                [1, 2],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 1],
                [0],
                [1],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 0],
                [],
                [],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [9, 9],
                [],
                [],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [8, 9],
                [0],
                [9],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [7, 9],
                [0, 1],
                [8, 9],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [3, 5],
                [0, 1],
                [4, 5],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [3, 4],
                [0],
                [4],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [3, 3],
                [],
                [],
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
                [],
            ],
            [
                $wrap([1]),
                [],
                [0],
                [1],
            ],
            [
                $wrap([null]),
                [],
                [0],
                [null],
            ],
            [
                $wrap([null, null]),
                [],
                [0, 1],
                [null, null],
            ],
            [
                $wrap([1, 2, 3]),
                [],
                [0, 1, 2],
                [1, 2, 3],
            ],
            [
                $wrap([1, 1, 1]),
                [],
                [0, 1, 2],
                [1, 1, 1],
            ],
            [
                $wrap([1, 1, 2]),
                [],
                [0, 1, 2],
                [1, 1, 2],
            ],
            [
                $wrap([1.1, 2.2, 3.3]),
                [],
                [0, 1, 2],
                [1.1, 2.2, 3.3],
            ],
            [
                $wrap(['1', '2', '3']),
                [],
                [0, 1, 2],
                ['1', '2', '3'],
            ],
            [
                $wrap([1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']]),
                [],
                [0, 1, 2, 3, 4, 5, 6, 7, 8],
                [1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 9],
                [0, 1, 2, 3, 4, 5, 6, 7, 8],
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 8],
                [0, 1, 2, 3, 4, 5, 6, 7],
                [1, 2, 3, 4, 5, 6, 7, 8],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 2],
                [0, 1],
                [1, 2],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 1],
                [0],
                [1],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 0],
                [],
                [],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [9, 9],
                [],
                [],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [8, 9],
                [0],
                [9],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [7, 9],
                [0, 1],
                [8, 9],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [3, 5],
                [0, 1],
                [4, 5],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [3, 4],
                [0],
                [4],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [3, 3],
                [],
                [],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForMultipleDirectionChangeReadArray
     * @dataProvider dataProviderForMultipleDirectionChangeReadArrayAccess
     * @param array|ArrayAccessList $input
     * @param array $config
     * @param int $readCount
     * @param array $expectedKeys
     * @param array $expectedValues
     * @return void
     */
    public function testMultipleDirectionChangeRead($input, array $config, int $readCount, array $expectedKeys, array $expectedValues): void
    {
        // Given
        $resultKeys = [];
        $resultValues = [];
        $iterator = new ListRandomAccessForwardIterator($input, ...$config);

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
    public function dataProviderForMultipleDirectionChangeReadArray(): array
    {
        return [
            [
                [1, 2, 3, 4, 5],
                [],
                1,
                [0, 1, 0, 4, 3, 2, 1, 0],
                [1, 2, 1, 5, 4, 3, 2, 1],
            ],
            [
                [1, 2, 3, 4, 5],
                [],
                2,
                [0, 1, 2, 1, 0, 4, 3, 2, 1, 0],
                [1, 2, 3, 2, 1, 5, 4, 3, 2, 1],
            ],
            [
                [1, 2, 3, 4, 5],
                [],
                3,
                [0, 1, 2, 3, 2, 1, 0, 4, 3, 2, 1, 0],
                [1, 2, 3, 4, 3, 2, 1, 5, 4, 3, 2, 1],
            ],
            [
                [1, 2, 3, 4, 5],
                [],
                4,
                [0, 1, 2, 3, 4, 3, 2, 1, 0, 4, 3, 2, 1, 0],
                [1, 2, 3, 4, 5, 4, 3, 2, 1, 5, 4, 3, 2, 1],
            ],
            [
                [1, 2, 3, 4, 5],
                [1, 4],
                1,
                [0, 1, 0, 2, 1, 0],
                [2, 3, 2, 4, 3, 2],
            ],
            [
                [1, 2, 3, 4, 5],
                [1, 4],
                2,
                [0, 1, 2, 1, 0, 2, 1, 0],
                [2, 3, 4, 3, 2, 4, 3, 2],
            ],
        ];
    }

    /**
     * @return array[]
     */
    public function dataProviderForMultipleDirectionChangeReadArrayAccess(): array
    {
        $wrap = fn ($data) => new ArrayAccessListFixture($data);

        return [
            [
                $wrap([1, 2, 3, 4, 5]),
                [],
                1,
                [0, 1, 0, 4, 3, 2, 1, 0],
                [1, 2, 1, 5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                [],
                2,
                [0, 1, 2, 1, 0, 4, 3, 2, 1, 0],
                [1, 2, 3, 2, 1, 5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                [],
                3,
                [0, 1, 2, 3, 2, 1, 0, 4, 3, 2, 1, 0],
                [1, 2, 3, 4, 3, 2, 1, 5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                [],
                4,
                [0, 1, 2, 3, 4, 3, 2, 1, 0, 4, 3, 2, 1, 0],
                [1, 2, 3, 4, 5, 4, 3, 2, 1, 5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                [1, 4],
                1,
                [0, 1, 0, 2, 1, 0],
                [2, 3, 2, 4, 3, 2],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                [1, 4],
                2,
                [0, 1, 2, 1, 0, 2, 1, 0],
                [2, 3, 4, 3, 2, 4, 3, 2],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForWriteArray
     * @dataProvider dataProviderForWriteArrayAccess
     * @param array|ArrayAccessList $input
     * @param array $config
     * @param callable $modifier
     * @param array $expectedStep1
     * @param array $expectedStep2
     * @return void
     */
    public function testWrite($input, array $config, callable $modifier, array $expectedStep1, array $expectedStep2): void
    {
        // Given
        $iterator = new ListRandomAccessForwardIterator($input, ...$config);

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
                [],
                fn ($value) => $value + 1,
                [2, 3, 4, 5, 6],
                [3, 4, 5, 6, 7],
            ],
            [
                [1, 2, 3, 4, 5],
                [0, 5],
                fn ($value) => $value + 1,
                [2, 3, 4, 5, 6],
                [3, 4, 5, 6, 7],
            ],
            [
                [1, 2, 3, 4, 5],
                [0, 4],
                fn ($value) => $value + 1,
                [2, 3, 4, 5, 5],
                [3, 4, 5, 6, 5],
            ],
            [
                [1, 2, 3, 4, 5],
                [1, 5],
                fn ($value) => $value + 1,
                [1, 3, 4, 5, 6],
                [1, 4, 5, 6, 7],
            ],
            [
                [1, 2, 3, 4, 5],
                [1, 4],
                fn ($value) => $value + 1,
                [1, 3, 4, 5, 5],
                [1, 4, 5, 6, 5],
            ],
            [
                [1, 2, 3, 4, 5],
                [1, 3],
                fn ($value) => $value + 1,
                [1, 3, 4, 4, 5],
                [1, 4, 5, 4, 5],
            ],
            [
                [1, 2, 3, 4, 5],
                [2, 4],
                fn ($value) => $value + 1,
                [1, 2, 4, 5, 5],
                [1, 2, 5, 6, 5],
            ],
            [
                [1, 2, 3, 4, 5],
                [2, 3],
                fn ($value) => $value + 1,
                [1, 2, 4, 4, 5],
                [1, 2, 5, 4, 5],
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
                [],
                fn ($value) => $value + 1,
                [2, 3, 4, 5, 6],
                [3, 4, 5, 6, 7],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                [0, 5],
                fn ($value) => $value + 1,
                [2, 3, 4, 5, 6],
                [3, 4, 5, 6, 7],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                [0, 4],
                fn ($value) => $value + 1,
                [2, 3, 4, 5, 5],
                [3, 4, 5, 6, 5],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                [1, 5],
                fn ($value) => $value + 1,
                [1, 3, 4, 5, 6],
                [1, 4, 5, 6, 7],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                [1, 4],
                fn ($value) => $value + 1,
                [1, 3, 4, 5, 5],
                [1, 4, 5, 6, 5],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                [1, 3],
                fn ($value) => $value + 1,
                [1, 3, 4, 4, 5],
                [1, 4, 5, 4, 5],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                [2, 4],
                fn ($value) => $value + 1,
                [1, 2, 4, 5, 5],
                [1, 2, 5, 6, 5],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                [2, 3],
                fn ($value) => $value + 1,
                [1, 2, 4, 4, 5],
                [1, 2, 5, 4, 5],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForAddNewItemsArray
     * @dataProvider dataProviderForAddNewItemsArrayAccess
     * @param array|ArrayAccessList $input
     * @param array $config
     * @param array $toAdd
     * @param array $expectedFromIterator
     * @param array $expectedActual
     * @return void
     */
    public function testAddNewItems($input, array $config, array $toAdd, array $expectedFromIterator, array $expectedActual): void
    {
        // Given
        $iterator = new ListRandomAccessForwardIterator($input, ...$config);
        $initialCount = \count($iterator);
        $result = [];

        // When
        foreach ($toAdd as $item) {
            $iterator[] = $item;
        }

        // And when
        foreach ($iterator as $value) {
            $result[] = $value;
        }

        $this->assertEquals(\count($toAdd), \count($iterator) - $initialCount);
        $this->assertEquals($expectedFromIterator, $result);
        $this->assertEquals(
            $expectedActual,
            ($input instanceof ArrayAccessListFixture) ? $input->toArray() : $input
        );
    }

    /**
     * @dataProvider dataProviderForAddNewItemsArray
     * @dataProvider dataProviderForAddNewItemsArrayAccess
     * @param array|ArrayAccessList $input
     * @param array $config
     * @param array $toAdd
     * @param array $expectedFromIterator
     * @param array $expectedActual
     * @return void
     */
    public function testAddNewItemsByIndex($input, array $config, array $toAdd, array $expectedFromIterator, array $expectedActual): void
    {
        // Given
        $iterator = new ListRandomAccessForwardIterator($input, ...$config);
        $initialCount = \count($iterator);
        $result = [];

        // When
        foreach ($toAdd as $item) {
            $iterator[count($iterator)] = $item;
        }

        // And when
        foreach ($iterator as $value) {
            $result[] = $value;
        }

        // Then
        $this->assertEquals(\count($toAdd), \count($iterator) - $initialCount);
        $this->assertEquals($expectedFromIterator, $result);
        $this->assertEquals(
            $expectedActual,
            ($input instanceof ArrayAccessListFixture) ? $input->toArray() : $input
        );
    }

    public function dataProviderForAddNewItemsArray(): array
    {
        return [
            [
                [],
                [],
                [],
                [],
                [],
            ],
            [
                [],
                [],
                [1],
                [1],
                [1],
            ],
            [
                [],
                [],
                [1, 2, 3],
                [1, 2, 3],
                [1, 2, 3],
            ],
            [
                [1],
                [],
                [2, 3, 4, 5],
                [1, 2, 3, 4, 5],
                [1, 2, 3, 4, 5],
            ],
            [
                [1, 2, 3],
                [],
                [4, 5, 6],
                [1, 2, 3, 4, 5, 6],
                [1, 2, 3, 4, 5, 6],
            ],
            [
                [],
                [0, 1],
                [],
                [],
                [],
            ],
            [
                [],
                [0, 2],
                [],
                [],
                [],
            ],
            [
                [],
                [0, 1],
                [1],
                [1],
                [1],
            ],
            [
                [],
                [0, 2],
                [1],
                [1],
                [1],
            ],
            [
                [],
                [0, 1],
                [1, 2, 3],
                [1, 2, 3],
                [1, 2, 3],
            ],
            [
                [],
                [0, 2],
                [1, 2, 3],
                [1, 2, 3],
                [1, 2, 3],
            ],
            [
                [1],
                [0, 1],
                [2, 3, 4, 5],
                [1, 2, 3, 4, 5],
                [1, 2, 3, 4, 5],
            ],
            [
                [1],
                [0, 2],
                [2, 3, 4, 5],
                [1, 2, 3, 4, 5],
                [1, 2, 3, 4, 5],
            ],
            [
                [1],
                [1, 2],
                [2, 3, 4, 5],
                [2, 3, 4, 5],
                [1, 2, 3, 4, 5],
            ],
            [
                [1],
                [1, 3],
                [2, 3, 4, 5],
                [2, 3, 4, 5],
                [1, 2, 3, 4, 5],
            ],
            [
                [1, 2, 3],
                [0, 3],
                [4, 5, 6],
                [1, 2, 3, 4, 5, 6],
                [1, 2, 3, 4, 5, 6],
            ],
            [
                [1, 2, 3],
                [1, 3],
                [4, 5, 6],
                [2, 3, 4, 5, 6],
                [1, 2, 3, 4, 5, 6],
            ],
            [
                [1, 2, 3],
                [1, 5],
                [4, 5, 6],
                [2, 3, 4, 5, 6],
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
                [],
                [],
            ],
            [
                $wrap([]),
                [],
                [1],
                [1],
                [1],
            ],
            [
                $wrap([]),
                [],
                [1, 2, 3],
                [1, 2, 3],
                [1, 2, 3],
            ],
            [
                $wrap([1]),
                [],
                [2, 3, 4, 5],
                [1, 2, 3, 4, 5],
                [1, 2, 3, 4, 5],
            ],
            [
                $wrap([1, 2, 3]),
                [],
                [4, 5, 6],
                [1, 2, 3, 4, 5, 6],
                [1, 2, 3, 4, 5, 6],
            ],
            [
                $wrap([]),
                [0, 1],
                [],
                [],
                [],
            ],
            [
                $wrap([]),
                [0, 2],
                [],
                [],
                [],
            ],
            [
                $wrap([]),
                [0, 1],
                [1],
                [1],
                [1],
            ],
            [
                $wrap([]),
                [0, 2],
                [1],
                [1],
                [1],
            ],
            [
                $wrap([]),
                [0, 1],
                [1, 2, 3],
                [1, 2, 3],
                [1, 2, 3],
            ],
            [
                $wrap([]),
                [0, 2],
                [1, 2, 3],
                [1, 2, 3],
                [1, 2, 3],
            ],
            [
                $wrap([1]),
                [0, 1],
                [2, 3, 4, 5],
                [1, 2, 3, 4, 5],
                [1, 2, 3, 4, 5],
            ],
            [
                $wrap([1]),
                [0, 2],
                [2, 3, 4, 5],
                [1, 2, 3, 4, 5],
                [1, 2, 3, 4, 5],
            ],
            [
                $wrap([1]),
                [1, 2],
                [2, 3, 4, 5],
                [2, 3, 4, 5],
                [1, 2, 3, 4, 5],
            ],
            [
                $wrap([1]),
                [1, 3],
                [2, 3, 4, 5],
                [2, 3, 4, 5],
                [1, 2, 3, 4, 5],
            ],
            [
                $wrap([1, 2, 3]),
                [0, 3],
                [4, 5, 6],
                [1, 2, 3, 4, 5, 6],
                [1, 2, 3, 4, 5, 6],
            ],
            [
                $wrap([1, 2, 3]),
                [1, 3],
                [4, 5, 6],
                [2, 3, 4, 5, 6],
                [1, 2, 3, 4, 5, 6],
            ],
            [
                $wrap([1, 2, 3]),
                [1, 5],
                [4, 5, 6],
                [2, 3, 4, 5, 6],
                [1, 2, 3, 4, 5, 6],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForMovePointerForwardArray
     * @dataProvider dataProviderForMovePointerForwardArrayAccess
     * @param array|ArrayAccessList $input
     * @param array $config
     * @param int $step
     * @param array $expected
     * @return void
     */
    public function testMovePointerForward($input, array $config, int $step, array $expected): void
    {
        // Given
        $result = [];
        $iterator = new ListRandomAccessForwardIterator($input, ...$config);

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
                [],
                1,
                [1],
            ],
            [
                [1],
                [],
                2,
                [1],
            ],
            [
                [1],
                [],
                3,
                [1],
            ],
            [
                [1, 2, 3, 4, 5],
                [],
                1,
                [1, 2, 3, 4, 5],
            ],
            [
                [1, 2, 3, 4, 5],
                [],
                2,
                [1, 3, 5],
            ],
            [
                [1, 2, 3, 4, 5],
                [],
                3,
                [1, 4],
            ],
            [
                [1, 2, 3, 4, 5],
                [],
                4,
                [1, 5],
            ],
            [
                [1, 2, 3, 4, 5],
                [],
                5,
                [1],
            ],
            [
                [1, 2, 3, 4, 5],
                [],
                6,
                [1],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                [0, 10],
                1,
                [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                [1, 10],
                1,
                [2, 3, 4, 5, 6, 7, 8, 9, 10],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                [0, 9],
                1,
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                [1, 9],
                1,
                [2, 3, 4, 5, 6, 7, 8, 9],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                [0, 10],
                2,
                [1, 3, 5, 7, 9],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                [1, 10],
                2,
                [2, 4, 6, 8, 10],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                [0, 9],
                2,
                [1, 3, 5, 7, 9],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                [0, 8],
                2,
                [1, 3, 5, 7],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                [1, 9],
                2,
                [2, 4, 6, 8],
            ],
        ];
    }

    public function dataProviderForMovePointerForwardArrayAccess(): array
    {
        $wrap = fn ($data) => new ArrayAccessListFixture($data);

        return [
            [
                $wrap([1]),
                [],
                1,
                [1],
            ],
            [
                $wrap([1]),
                [],
                2,
                [1],
            ],
            [
                $wrap([1]),
                [],
                3,
                [1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                [],
                1,
                [1, 2, 3, 4, 5],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                [],
                2,
                [1, 3, 5],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                [],
                3,
                [1, 4],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                [],
                4,
                [1, 5],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                [],
                5,
                [1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                [],
                6,
                [1],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
                [0, 10],
                1,
                [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
                [1, 10],
                1,
                [2, 3, 4, 5, 6, 7, 8, 9, 10],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
                [0, 9],
                1,
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
                [1, 9],
                1,
                [2, 3, 4, 5, 6, 7, 8, 9],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
                [0, 10],
                2,
                [1, 3, 5, 7, 9],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
                [1, 10],
                2,
                [2, 4, 6, 8, 10],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
                [0, 9],
                2,
                [1, 3, 5, 7, 9],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
                [0, 8],
                2,
                [1, 3, 5, 7],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
                [1, 9],
                2,
                [2, 4, 6, 8],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForMovePointerReverseArray
     * @dataProvider dataProviderForMovePointerReverseArrayAccess
     * @param array|ArrayAccessList $input
     * @param array $config
     * @param int $step
     * @param array $expected
     * @return void
     */
    public function testMovePointerReverse($input, array $config, int $step, array $expected): void
    {
        // Given
        $result = [];
        $iterator = new ListRandomAccessForwardIterator($input, ...$config);

        // When
        for ($iterator->last(); $iterator->valid(); $iterator->movePointer(-$step)) {
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
                [],
                1,
                [1],
            ],
            [
                [1],
                [],
                2,
                [1],
            ],
            [
                [1],
                [],
                3,
                [1],
            ],
            [
                [1, 2, 3, 4, 5],
                [],
                1,
                [5, 4, 3, 2, 1],
            ],
            [
                [1, 2, 3, 4, 5],
                [],
                2,
                [5, 3, 1],
            ],
            [
                [1, 2, 3, 4, 5],
                [],
                3,
                [5, 2],
            ],
            [
                [1, 2, 3, 4, 5],
                [],
                4,
                [5, 1],
            ],
            [
                [1, 2, 3, 4, 5],
                [],
                5,
                [5],
            ],
            [
                [1, 2, 3, 4, 5],
                [],
                6,
                [5],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                [0, 10],
                1,
                [10, 9, 8, 7, 6, 5, 4, 3, 2, 1],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                [1, 10],
                1,
                [10, 9, 8, 7, 6, 5, 4, 3, 2],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                [0, 9],
                1,
                [9, 8, 7, 6, 5, 4, 3, 2, 1],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                [1, 9],
                1,
                [9, 8, 7, 6, 5, 4, 3, 2],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                [0, 10],
                2,
                [10, 8, 6, 4, 2],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                [1, 10],
                2,
                [10, 8, 6, 4, 2],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                [2, 10],
                2,
                [10, 8, 6, 4],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                [0, 9],
                2,
                [9, 7, 5, 3, 1],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                [0, 8],
                2,
                [8, 6, 4, 2],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                [1, 9],
                2,
                [9, 7, 5, 3],
            ],
        ];
    }

    public function dataProviderForMovePointerReverseArrayAccess(): array
    {
        $wrap = fn ($data) => new ArrayAccessListFixture($data);

        return [
            [
                $wrap([1]),
                [],
                1,
                [1],
            ],
            [
                $wrap([1]),
                [],
                2,
                [1],
            ],
            [
                $wrap([1]),
                [],
                3,
                [1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                [],
                1,
                [5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                [],
                2,
                [5, 3, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                [],
                3,
                [5, 2],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                [],
                4,
                [5, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                [],
                5,
                [5],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                [],
                6,
                [5],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
                [0, 10],
                1,
                [10, 9, 8, 7, 6, 5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
                [1, 10],
                1,
                [10, 9, 8, 7, 6, 5, 4, 3, 2],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
                [0, 9],
                1,
                [9, 8, 7, 6, 5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
                [1, 9],
                1,
                [9, 8, 7, 6, 5, 4, 3, 2],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
                [0, 10],
                2,
                [10, 8, 6, 4, 2],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
                [1, 10],
                2,
                [10, 8, 6, 4, 2],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
                [2, 10],
                2,
                [10, 8, 6, 4],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
                [0, 9],
                2,
                [9, 7, 5, 3, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
                [0, 8],
                2,
                [8, 6, 4, 2],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
                [1, 9],
                2,
                [9, 7, 5, 3],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForIsInvalidOutOfBoundsArray
     * @dataProvider dataProviderForIsInvalidOutOfBoundsArrayAccess
     * @param array|ArrayAccessList $input
     * @param array $config
     * @return void
     */
    public function testIsInvalidAfterLastItem($input, array $config): void
    {
        // Given
        $iterator = new ListRandomAccessForwardIterator($input, ...$config);

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

    /**
     * @dataProvider dataProviderForIsInvalidOutOfBoundsArray
     * @dataProvider dataProviderForIsInvalidOutOfBoundsArrayAccess
     * @param array|ArrayAccessList $input
     * @param array $config
     * @return void
     */
    public function testIsInvalidBeforeFirstItem($input, array $config): void
    {
        // Given
        $iterator = new ListRandomAccessForwardIterator($input, ...$config);

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

    public function dataProviderForIsInvalidOutOfBoundsArray(): array
    {
        return [
            [[], []],
            [[1], []],
            [[1, 2], []],
            [[1, 2, 3], []],
            [[], [0, 0]],
            [[], [0, 1]],
            [[], [1, 2]],
            [[1, 2], [0, 0]],
            [[1, 2], [0, 1]],
            [[1, 2], [0, 2]],
            [[1, 2], [0, 3]],
            [[1, 2, 3], [0, 0]],
            [[1, 2, 3], [0, 1]],
            [[1, 2, 3], [0, 2]],
            [[1, 2, 3], [0, 3]],
            [[1, 2, 3], [1, 2]],
            [[1, 2, 3], [2, 3]],
            [[1, 2, 3], [2, 5]],
        ];
    }

    public function dataProviderForIsInvalidOutOfBoundsArrayAccess(): array
    {
        $wrap = fn ($data) => new ArrayAccessListFixture($data);

        return [
            [$wrap([]), []],
            [$wrap([1]), []],
            [$wrap([1, 2]), []],
            [$wrap([1, 2, 3]), []],
            [$wrap([]), [0, 0]],
            [$wrap([]), [0, 1]],
            [$wrap([]), [1, 2]],
            [$wrap([1, 2]), [0, 0]],
            [$wrap([1, 2]), [0, 1]],
            [$wrap([1, 2]), [0, 2]],
            [$wrap([1, 2]), [0, 3]],
            [$wrap([1, 2, 3]), [0, 0]],
            [$wrap([1, 2, 3]), [0, 1]],
            [$wrap([1, 2, 3]), [0, 2]],
            [$wrap([1, 2, 3]), [0, 3]],
            [$wrap([1, 2, 3]), [1, 2]],
            [$wrap([1, 2, 3]), [2, 3]],
            [$wrap([1, 2, 3]), [2, 5]],
        ];
    }

    /**
     * @dataProvider dataProviderForReadMultipleIteratorsSimultaneouslyArray
     * @dataProvider dataProviderForReadMultipleIteratorsSimultaneouslyArrayAccess
     * @param array|ArrayAccessList $input
     * @param array $config
     * @param array $expectedDirect
     * @param array $expectedReverse
     * @return void
     */
    public function testReadMultipleIteratorsSimultaneously($input, array $config, array $expectedDirect, array $expectedReverse): void
    {
        // Given
        $iterator1 = new ListRandomAccessForwardIterator($input, ...$config);
        $iterator2 = new ListRandomAccessForwardIterator($input, ...$config);
        $iterator3 = new ListRandomAccessReverseIterator($input, ...$config);
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

    public function dataProviderForReadMultipleIteratorsSimultaneouslyArray(): array
    {
        return [
            [
                [],
                [],
                [],
                [],
            ],
            [
                [1],
                [],
                [1],
                [1],
            ],
            [
                [null],
                [],
                [null],
                [null],
            ],
            [
                [null, null],
                [],
                [null, null],
                [null, null],
            ],
            [
                [1, 2, 3],
                [],
                [1, 2, 3],
                [3, 2, 1],
            ],
            [
                [1, 1, 1],
                [],
                [1, 1, 1],
                [1, 1, 1],
            ],
            [
                [1, 1, 2],
                [],
                [1, 1, 2],
                [2, 1, 1],
            ],
            [
                [1.1, 2.2, 3.3],
                [],
                [1.1, 2.2, 3.3],
                [3.3, 2.2, 1.1],
            ],
            [
                ['1', '2', '3'],
                [],
                ['1', '2', '3'],
                ['3', '2', '1'],
            ],
            [
                [1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']],
                [],
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
                [],
            ],
            [
                $wrap([1]),
                [],
                [1],
                [1],
            ],
            [
                $wrap([null]),
                [],
                [null],
                [null],
            ],
            [
                $wrap([null, null]),
                [],
                [null, null],
                [null, null],
            ],
            [
                $wrap([1, 2, 3]),
                [],
                [1, 2, 3],
                [3, 2, 1],
            ],
            [
                $wrap([1, 1, 1]),
                [],
                [1, 1, 1],
                [1, 1, 1],
            ],
            [
                $wrap([1, 1, 2]),
                [],
                [1, 1, 2],
                [2, 1, 1],
            ],
            [
                $wrap([1.1, 2.2, 3.3]),
                [],
                [1.1, 2.2, 3.3],
                [3.3, 2.2, 1.1],
            ],
            [
                $wrap(['1', '2', '3']),
                [],
                ['1', '2', '3'],
                ['3', '2', '1'],
            ],
            [
                $wrap([1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']]),
                [],
                [1, 2.2, '3', '', true, false, null, [1, 2, 3], (object)['a', 'b', 'c']],
                [(object)['a', 'b', 'c'], [1, 2, 3], null, false, true, '', '3', 2.2, 1],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForReadMultiplePartialIteratorsSimultaneouslyArray
     * @dataProvider dataProviderForReadMultiplePartialIteratorsSimultaneouslyArrayAccess
     * @param array|ArrayAccessList $input
     * @param array $config
     * @param array $expectedDirect
     * @param array $expectedReverse
     * @return void
     */
    public function testReadMultiplePartialIteratorsSimultaneously($input, array $config, array $expectedDirect, array $expectedReverse): void
    {
        // Given
        $iterator1 = new ListRandomAccessForwardIterator($input, ...$config);
        $iterator2 = new ListRandomAccessForwardIterator($input, ...$config);
        $iterator3 = new ListRandomAccessReverseIterator($input, ...$config);

        $result1 = [];
        $result2 = [];
        $result3 = [];

        // When
        $iterator1->rewind();
        $iterator2->rewind();
        $iterator3->rewind();

        while (true) {
            if (!$iterator1->valid() && !$iterator2->valid() && !$iterator3->valid()) {
                break;
            }

            $result1[] = $iterator1->current();
            $result2[] = $iterator2->current();
            $result3[] = $iterator3->current();

            $iterator1->next();
            $iterator2->next();
            $iterator3->next();
        }

        // Then
        $this->assertEquals($expectedDirect, $result1);
        $this->assertEquals($expectedDirect, $result2);
        $this->assertEquals($expectedReverse, $result3);
    }

    public function dataProviderForReadMultiplePartialIteratorsSimultaneouslyArray(): array
    {
        return [
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 9],
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [9, 8, 7, 6, 5, 4, 3, 2, 1],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 8],
                [1, 2, 3, 4, 5, 6, 7, 8],
                [9, 8, 7, 6, 5, 4, 3, 2],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 2],
                [1, 2],
                [9, 8],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 1],
                [1],
                [9],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 0],
                [],
                [],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [9, 9],
                [],
                [],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [8, 9],
                [9],
                [1],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [7, 9],
                [8, 9],
                [2, 1],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [3, 5],
                [4, 5],
                [6, 5],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [3, 4],
                [4],
                [6],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [3, 3],
                [],
                [],
            ],
        ];
    }

    public function dataProviderForReadMultiplePartialIteratorsSimultaneouslyArrayAccess(): array
    {
        $wrap = fn ($data) => new ArrayAccessListFixture($data);

        return [
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 9],
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [9, 8, 7, 6, 5, 4, 3, 2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 8],
                [1, 2, 3, 4, 5, 6, 7, 8],
                [9, 8, 7, 6, 5, 4, 3, 2],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 2],
                [1, 2],
                [9, 8],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 1],
                [1],
                [9],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [0, 0],
                [],
                [],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [9, 9],
                [],
                [],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [8, 9],
                [9],
                [1],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [7, 9],
                [8, 9],
                [2, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [3, 5],
                [4, 5],
                [6, 5],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [3, 4],
                [4],
                [6],
            ],
            [
                $wrap([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                [3, 3],
                [],
                [],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForCountArray
     * @dataProvider dataProviderForCountArrayAccess
     * @param array|ArrayAccessList $input
     * @param array $config
     * @param int $expected
     * @return void
     */
    public function testCount($input, array $config, int $expected): void
    {
        // When
        $iterator = new ListRandomAccessForwardIterator($input, ...$config);

        // Then
        $this->assertCount($expected, $iterator);
    }

    public function dataProviderForCountArray(): array
    {
        return [
            [[], [], 0],
            [[1], [], 1],
            [[1, 2], [], 2],
            [[1, 2, 3], [], 3],
            [[], [0, 0], 0],
            [[], [0, 1], 0],
            [[], [0, 2], 0],
            [[1, 2, 3, 4, 5], [0, 5], 5],
            [[1, 2, 3, 4, 5], [0, 4], 4],
            [[1, 2, 3, 4, 5], [1, 5], 4],
            [[1, 2, 3, 4, 5], [1, 4], 3],
            [[1, 2, 3, 4, 5], [1, 3], 2],
            [[1, 2, 3, 4, 5], [2, 3], 1],
            [[1, 2, 3, 4, 5], [2, 2], 0],
            [[1, 2, 3, 4, 5], [0, 0], 0],
        ];
    }

    public function dataProviderForCountArrayAccess(): array
    {
        $wrap = fn ($data) => new ArrayAccessListFixture($data);

        return [
            [$wrap([]), [], 0],
            [$wrap([1]), [], 1],
            [$wrap([1, 2]), [], 2],
            [$wrap([1, 2, 3]), [], 3],
            [$wrap([]), [0, 0], 0],
            [$wrap([]), [0, 1], 0],
            [$wrap([]), [0, 2], 0],
            [$wrap([1, 2, 3, 4, 5]), [0, 5], 5],
            [$wrap([1, 2, 3, 4, 5]), [0, 4], 4],
            [$wrap([1, 2, 3, 4, 5]), [1, 5], 4],
            [$wrap([1, 2, 3, 4, 5]), [1, 4], 3],
            [$wrap([1, 2, 3, 4, 5]), [1, 3], 2],
            [$wrap([1, 2, 3, 4, 5]), [2, 3], 1],
            [$wrap([1, 2, 3, 4, 5]), [2, 2], 0],
            [$wrap([1, 2, 3, 4, 5]), [0, 0], 0],
        ];
    }

    /**
     * @dataProvider dataProviderForErrorOnSetArray
     * @dataProvider dataProviderForErrorOnSetArrayAccess
     * @param array|ArrayAccessList $input
     * @param array $config
     * @param int|null $offset
     * @param string $exceptionClass
     * @return void
     */
    public function testErrorOnSet($input, array $config, ?int $offset, string $exceptionClass): void
    {
        // Given
        $iterator = new ListRandomAccessForwardIterator($input, ...$config);

        // Then
        $this->expectException($exceptionClass);

        // When
        $iterator[$offset] = 1;
    }

    public function dataProviderForErrorOnSetArray(): array
    {
        return [
            [[], [], -1, \OutOfBoundsException::class],
            [[], [], 1, \OutOfBoundsException::class],
            [[1], [], -1, \OutOfBoundsException::class],
            [[1], [], 2, \OutOfBoundsException::class],
            [[1, 2, 3, 4, 5], [], -1, \OutOfBoundsException::class],
            [[1, 2, 3, 4, 5], [0, 5], -1, \OutOfBoundsException::class],
            [[1, 2, 3, 4, 5], [0, 4], -1, \OutOfBoundsException::class],
            [[1, 2, 3, 4, 5], [1, 5], -1, \OutOfBoundsException::class],
            [[1, 2, 3, 4, 5], [1, 4], -1, \OutOfBoundsException::class],
            [[1, 2, 3, 4, 5], [], 6, \OutOfBoundsException::class],
            [[1, 2, 3, 4, 5], [0, 5], 6, \OutOfBoundsException::class],
            [[1, 2, 3, 4, 5], [0, 4], 5, \OutOfBoundsException::class],
            [[1, 2, 3, 4, 5], [1, 5], 5, \OutOfBoundsException::class],
            [[1, 2, 3, 4, 5], [1, 4], 4, \OutOfBoundsException::class],
            [[1, 2, 3, 4, 5], [1, 4], 3, \RangeException::class],
            [[1, 2, 3, 4, 5], [2, 4], 3, \OutOfBoundsException::class],
            [[1, 2, 3, 4, 5], [2, 4], 2, \RangeException::class],
            [[1, 2, 3, 4, 5], [3, 4], 2, \OutOfBoundsException::class],
            [[1, 2, 3, 4, 5], [3, 4], 1, \RangeException::class],
            [[1, 2, 3, 4, 5], [3, 3], 1, \OutOfBoundsException::class],
            [[1, 2, 3, 4, 5], [3, 3], 0, \RangeException::class],
        ];
    }

    public function dataProviderForErrorOnSetArrayAccess(): array
    {
        $wrap = fn ($data) => new ArrayAccessListFixture($data);

        return [
            [$wrap([]), [], -1, \OutOfBoundsException::class],
            [$wrap([]), [], 1, \OutOfBoundsException::class],
            [$wrap([1]), [], -1, \OutOfBoundsException::class],
            [$wrap([1]), [], 2, \OutOfBoundsException::class],
            [$wrap([1, 2, 3, 4, 5]), [], -1, \OutOfBoundsException::class],
            [$wrap([1, 2, 3, 4, 5]), [0, 5], -1, \OutOfBoundsException::class],
            [$wrap([1, 2, 3, 4, 5]), [0, 4], -1, \OutOfBoundsException::class],
            [$wrap([1, 2, 3, 4, 5]), [1, 5], -1, \OutOfBoundsException::class],
            [$wrap([1, 2, 3, 4, 5]), [1, 4], -1, \OutOfBoundsException::class],
            [$wrap([1, 2, 3, 4, 5]), [], 6, \OutOfBoundsException::class],
            [$wrap([1, 2, 3, 4, 5]), [0, 5], 6, \OutOfBoundsException::class],
            [$wrap([1, 2, 3, 4, 5]), [0, 4], 5, \OutOfBoundsException::class],
            [$wrap([1, 2, 3, 4, 5]), [1, 5], 5, \OutOfBoundsException::class],
            [$wrap([1, 2, 3, 4, 5]), [1, 4], 4, \OutOfBoundsException::class],
            [$wrap([1, 2, 3, 4, 5]), [1, 4], 3, \RangeException::class],
            [$wrap([1, 2, 3, 4, 5]), [2, 4], 3, \OutOfBoundsException::class],
            [$wrap([1, 2, 3, 4, 5]), [2, 4], 2, \RangeException::class],
            [$wrap([1, 2, 3, 4, 5]), [3, 4], 2, \OutOfBoundsException::class],
            [$wrap([1, 2, 3, 4, 5]), [3, 4], 1, \RangeException::class],
            [$wrap([1, 2, 3, 4, 5]), [3, 3], 1, \OutOfBoundsException::class],
            [$wrap([1, 2, 3, 4, 5]), [3, 3], 0, \RangeException::class],
        ];
    }

    /**
     * @dataProvider dataProviderForPopUntilEmptyArray
     * @dataProvider dataProviderForPopUntilEmptyArrayAccess
     * @param array|ArrayAccessList $input
     * @param array $config
     * @return void
     */
    public function testPopUntilEmpty($input, array $config): void
    {
        // Given
        $iterator = new ListRandomAccessForwardIterator($input, ...$config);
        $result = [];
        $initialCount = \count($input);
        $start = $config[0] ?? 0;
        $end = $config[1] ?? $initialCount;

        // When
        while (\count($iterator)) {
            unset($iterator[\count($iterator) - 1]);
        }
        foreach ($iterator as $item) {
            $result[] = $item;
        }

        // Then
        $this->assertEmpty($result);
        $this->assertCount($initialCount - ($end - $start), $input);
    }

    public function dataProviderForPopUntilEmptyArray(): array
    {
        return [
            [[], []],
            [[1], []],
            [[1, 2], []],
            [[1, 2, 3], []],
            [[1, 2, 3, 4], []],
            [[1, 1, 1, 1, 1], []],
            [[], [0, 0]],
            [[1], [0, 0]],
            [[1], [0, 1]],
            [[1, 2, 3, 4, 5], [0, 5]],
            [[1, 2, 3, 4, 5], [1, 5]],
            [[1, 2, 3, 4, 5], [2, 5]],
            [[1, 2, 3, 4, 5], [3, 5]],
            [[1, 2, 3, 4, 5], [4, 5]],
            [[1, 2, 3, 4, 5], [5, 5]],
        ];
    }

    public function dataProviderForPopUntilEmptyArrayAccess(): array
    {
        $wrap = fn ($data) => new ArrayAccessListFixture($data);

        return [
            [$wrap([]), []],
            [$wrap([1]), []],
            [$wrap([1, 2]), []],
            [$wrap([1, 2, 3]), []],
            [$wrap([1, 2, 3, 4]), []],
            [$wrap([1, 1, 1, 1, 1]), []],
            [$wrap([]), [0, 0]],
            [$wrap([1]), [0, 0]],
            [$wrap([1]), [0, 1]],
            [$wrap([1, 2, 3, 4, 5]), [0, 5]],
            [$wrap([1, 2, 3, 4, 5]), [1, 5]],
            [$wrap([1, 2, 3, 4, 5]), [2, 5]],
            [$wrap([1, 2, 3, 4, 5]), [3, 5]],
            [$wrap([1, 2, 3, 4, 5]), [4, 5]],
            [$wrap([1, 2, 3, 4, 5]), [5, 5]],
        ];
    }

    /**
     * @dataProvider dataProviderForIteratorIsInvalidAfterPopArray
     * @dataProvider dataProviderForIteratorIsInvalidAfterPopArrayAccess
     * @param array|ArrayAccessList $input
     * @param array $config
     * @return void
     */
    public function testIteratorIsInvalidAfterPop($input, array $config): void
    {
        // Given
        $iterator = new ListRandomAccessForwardIterator($input, ...$config);

        // When
        foreach ($iterator as $i => $item) {
            if ($i === count($iterator) - 1) {
                // Then
                $this->assertTrue($iterator->valid());

                // And when
                unset($iterator[$i]);

                // Then
                $this->assertFalse($iterator->valid());
            }
        }
    }

    public function dataProviderForIteratorIsInvalidAfterPopArray(): array
    {
        return [
            [[1], []],
            [[1, 2], []],
            [[1, 2, 3], []],
            [[1, 2, 3, 4], []],
            [[1, 1, 1, 1, 1], []],
            [[1], [0, 1]],
            [[1, 2, 3, 4, 5], [0, 5]],
            [[1, 2, 3, 4, 5], [1, 5]],
            [[1, 2, 3, 4, 5], [2, 5]],
            [[1, 2, 3, 4, 5], [3, 5]],
            [[1, 2, 3, 4, 5], [4, 5]],
        ];
    }

    public function dataProviderForIteratorIsInvalidAfterPopArrayAccess(): array
    {
        $wrap = fn ($data) => new ArrayAccessListFixture($data);

        return [
            [$wrap([1]), []],
            [$wrap([1, 2]), []],
            [$wrap([1, 2, 3]), []],
            [$wrap([1, 2, 3, 4]), []],
            [$wrap([1, 1, 1, 1, 1]), []],
            [$wrap([1]), [0, 1]],
            [$wrap([1, 2, 3, 4, 5]), [0, 5]],
            [$wrap([1, 2, 3, 4, 5]), [1, 5]],
            [$wrap([1, 2, 3, 4, 5]), [2, 5]],
            [$wrap([1, 2, 3, 4, 5]), [3, 5]],
            [$wrap([1, 2, 3, 4, 5]), [4, 5]],
        ];
    }

    /**
     * @dataProvider dataProviderForUnsetFromTailArray
     * @dataProvider dataProviderForUnsetFromTailArrayAccess
     * @param array|ArrayAccessList $input
     * @param array $config
     * @param int $offset
     * @param array $expected
     * @return void
     */
    public function testUnsetFromTail($input, array $config, int $offset, array $expected): void
    {
        // Given
        $iterator = new ListRandomAccessForwardIterator($input, ...$config);
        $result = [];

        // When
        unset($iterator[$offset]);
        foreach ($iterator as $item) {
            $result[] = $item;
        }

        // Then
        $this->assertEquals($expected, $result);
    }

    public function dataProviderForUnsetFromTailArray(): array
    {
        return [
            [
                [1],
                [],
                0,
                [],
            ],
            [
                [1, 2],
                [],
                1,
                [1],
            ],
            [
                [1, 2, 3],
                [],
                2,
                [1, 2],
            ],
            [
                [1, 2, 3, 4],
                [],
                3,
                [1, 2, 3],
            ],
            [
                [1, 1, 1, 1, 1],
                [],
                4,
                [1, 1, 1, 1],
            ],
            [
                [1, 2, 3, 4, 5],
                [],
                4,
                [1, 2, 3, 4],
            ],
            [
                [1, 2, 3, 4, 5],
                [0, 5],
                4,
                [1, 2, 3, 4],
            ],
            [
                [1, 2, 3, 4, 5],
                [1, 5],
                3,
                [2, 3, 4],
            ],
            [
                [1, 2, 3, 4, 5],
                [2, 5],
                2,
                [3, 4],
            ],
            [
                [1, 2, 3, 4, 5],
                [3, 5],
                1,
                [4],
            ],
            [
                [1, 2, 3, 4, 5],
                [4, 5],
                0,
                [],
            ],
        ];
    }

    public function dataProviderForUnsetFromTailArrayAccess(): array
    {
        $wrap = fn ($data) => new ArrayAccessListFixture($data);

        return [
            [
                $wrap([1]),
                [],
                0,
                [],
            ],
            [
                $wrap([1, 2]),
                [],
                1,
                [1],
            ],
            [
                $wrap([1, 2, 3]),
                [],
                2,
                [1, 2],
            ],
            [
                $wrap([1, 2, 3, 4]),
                [],
                3,
                [1, 2, 3],
            ],
            [
                $wrap([1, 1, 1, 1, 1]),
                [],
                4,
                [1, 1, 1, 1],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                [],
                4,
                [1, 2, 3, 4],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                [0, 5],
                4,
                [1, 2, 3, 4],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                [1, 5],
                3,
                [2, 3, 4],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                [2, 5],
                2,
                [3, 4],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                [3, 5],
                1,
                [4],
            ],
            [
                $wrap([1, 2, 3, 4, 5]),
                [4, 5],
                0,
                [],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForErrorOnUnsetFromMiddleArray
     * @dataProvider dataProviderForErrorOnUnsetFromMiddleArrayAccess
     * @param array|ArrayAccessList $input
     * @param array $config
     * @param int $offset
     * @return void
     */
    public function testErrorOnUnsetFromMiddle($input, array $config, int $offset): void
    {
        // Given
        $iterator = new ListRandomAccessForwardIterator($input, ...$config);

        // Then
        $this->expectException(\InvalidArgumentException::class);

        // When
        unset($iterator[$offset]);
    }

    public function dataProviderForErrorOnUnsetFromMiddleArray(): array
    {
        return [
            [[1, 2], [], 0],
            [[1, 2, 3], [], 0],
            [[1, 2, 3], [], 1],
            [[1, 2, 3, 4], [], 0],
            [[1, 2, 3, 4], [], 1],
            [[1, 2, 3, 4], [], 2],
            [[1, 2, 3, 4, 5], [], 2],
            [[1, 2, 3, 4, 5], [0, 5], 2],
            [[1, 2, 3, 4, 5], [1, 5], 2],
        ];
    }

    public function dataProviderForErrorOnUnsetFromMiddleArrayAccess(): array
    {
        $wrap = fn ($data) => new ArrayAccessListFixture($data);

        return [
            [$wrap([1, 2]), [], 0],
            [$wrap([1, 2, 3]), [], 0],
            [$wrap([1, 2, 3]), [], 1],
            [$wrap([1, 2, 3, 4]), [], 0],
            [$wrap([1, 2, 3, 4]), [], 1],
            [$wrap([1, 2, 3, 4]), [], 2],
            [$wrap([1, 2, 3, 4, 5]), [0, 5], 2],
            [$wrap([1, 2, 3, 4, 5]), [1, 5], 2],
        ];
    }

    /**
     * @dataProvider dataProviderForErrorOutOfBoundsOnUnsetArray
     * @dataProvider dataProviderForErrorOutOfBoundsOnUnsetArrayAccess
     * @param array|ArrayAccessList $input
     * @param array $config
     * @param int $offset
     * @return void
     */
    public function testErrorOutOfBoundsOnUnset($input, array $config, int $offset): void
    {
        // Given
        $iterator = new ListRandomAccessForwardIterator($input, ...$config);

        // Then
        $this->expectException(\OutOfBoundsException::class);

        // When
        unset($iterator[$offset]);
    }

    public function dataProviderForErrorOutOfBoundsOnUnsetArray(): array
    {
        return [
            [[], [], 0],
            [[], [], 1],
            [[], [], -1],
            [[1], [], 1],
            [[1], [], -1],
            [[1, 2, 3], [], 3],
            [[1, 2, 3], [], -1],
            [[1, 2, 3, 4], [], 4],
            [[1, 2, 3, 4], [], 5],
            [[1, 2, 3, 4], [], -1],
            [[1, 2, 3, 4], [], -2],
            [[1, 2, 3, 4, 5], [1, 4], 4],
            [[1, 2, 3, 4, 5], [1, 3], 4],
            [[1, 2, 3, 4, 5], [1, 3], 3],
        ];
    }

    public function dataProviderForErrorOutOfBoundsOnUnsetArrayAccess(): array
    {
        $wrap = fn ($data) => new ArrayAccessListFixture($data);

        return [
            [$wrap([]), [], 0],
            [$wrap([]), [], 1],
            [$wrap([]), [], -1],
            [$wrap([1]), [], 1],
            [$wrap([1]), [], -1],
            [$wrap([1, 2, 3]), [], 3],
            [$wrap([1, 2, 3]), [], -1],
            [$wrap([1, 2, 3, 4]), [], 4],
            [$wrap([1, 2, 3, 4]), [], 5],
            [$wrap([1, 2, 3, 4]), [], -1],
            [$wrap([1, 2, 3, 4]), [], -2],
            [$wrap([1, 2, 3, 4, 5]), [1, 4], 4],
            [$wrap([1, 2, 3, 4, 5]), [1, 3], 4],
            [$wrap([1, 2, 3, 4, 5]), [1, 3], 3],
        ];
    }

    /**
     * @dataProvider dataProviderForRangeErrorOnUnsetArray
     * @dataProvider dataProviderForRangeErrorOnUnsetArrayAccess
     * @param array|ArrayAccessList $input
     * @param array $config
     * @param int $offset
     * @return void
     */
    public function testRangeErrorOnUnset($input, array $config, int $offset): void
    {
        // Given
        $iterator = new ListRandomAccessForwardIterator($input, ...$config);

        // Then
        $this->expectException(\RangeException::class);

        // When
        unset($iterator[$offset]);
    }

    public function dataProviderForRangeErrorOnUnsetArray(): array
    {
        return [
            [[1, 2, 3, 4, 5], [0, 4], 3],
            [[1, 2, 3, 4, 5], [1, 4], 2],
            [[1, 2, 3, 4, 5], [2, 4], 1],
            [[1, 2, 3, 4, 5], [3, 4], 0],
        ];
    }

    public function dataProviderForRangeErrorOnUnsetArrayAccess(): array
    {
        $wrap = fn ($data) => new ArrayAccessListFixture($data);

        return [
            [$wrap([1, 2, 3, 4, 5]), [0, 4], 3],
            [$wrap([1, 2, 3, 4, 5]), [1, 4], 2],
            [$wrap([1, 2, 3, 4, 5]), [2, 4], 1],
            [$wrap([1, 2, 3, 4, 5]), [3, 4], 0],
        ];
    }
}
