<?php

declare(strict_types=1);

namespace IterTools\Tests\Iterators;

use IterTools\Iterators\RandomAccessDirectIterator;

class RandomAccessDirectIteratorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider dataProviderForTestDirectReadForEach
     * @param array $input
     * @param array $expected
     * @return void
     */
    public function testDirectReadForEach(array $input, array $expected): void
    {
        // Given
        $result = [];
        $iterator = new RandomAccessDirectIterator($input);

        // When
        foreach ($iterator as $key => $item) {
            $result[$key] = $item;
        }

        // Then
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function dataProviderForTestDirectReadForEach(): array
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
}
