<?php

declare(strict_types=1);

namespace IterTools\Tests\Chain;

use IterTools\Chain;

class ReduceTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @param array $input
     * @param callable $reducer
     * @param mixed $expected
     * @return void
     * @dataProvider dataProviderForArray
     */
    public function testArray(array $input, callable $reducer, $expected): void
    {
        // Given
        // When
        $result = $reducer($input);

        // Then
        $this->assertSame($expected, $result);
    }

    public function dataProviderForArray(): array
    {
        return [
            [
                [],
                static function (array $iterable) {
                    return Chain::create($iterable)->toCount();
                },
                0,
            ],
            [
                [1, -1, 2, -2, 3, -3],
                static function (array $iterable) {
                    return Chain::create($iterable)->toCount();
                },
                6,
            ],
            [
                [],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterTrue(static function ($value) {
                            return $value > 0;
                        })
                        ->toCount();
                },
                0,
            ],
            [
                [1, -1, 2, -2, 3, -3],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterTrue(static function ($value) {
                            return $value > 0;
                        })
                        ->toCount();
                },
                3,
            ],
            [
                [],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterTrue(static function ($value) {
                            return $value > 0;
                        })
                        ->pairwise()
                        ->toCount();
                },
                0,
            ],
            [
                [1, -1, 2, -2, 3, -3],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterTrue(static function ($value) {
                            return $value > 0;
                        })
                        ->pairwise()
                        ->toCount();
                },
                2,
            ],
            [
                [],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterFalse(static function ($value) {
                            return $value > 0;
                        })
                        ->toCount();
                },
                0,
            ],
            [
                [1, -1, 2, -2, 3, -3],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterFalse(static function ($value) {
                            return $value > 0;
                        })
                        ->toCount();
                },
                3,
            ],
            [
                [],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterFalse(static function ($value) {
                            return $value > 0;
                        })
                        ->pairwise()
                        ->toCount();
                },
                0,
            ],
            [
                [1, -1, 2, -2, 3, -3],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterFalse(static function ($value) {
                            return $value > 0;
                        })
                        ->pairwise()
                        ->toCount();
                },
                2,
            ],
            [
                [],
                static function (array $iterable) {
                    return Chain::create($iterable)->toAverage();
                },
                null,
            ],
            [
                [1, -1, 2, -2, 3, -3],
                static function (array $iterable) {
                    return Chain::create($iterable)->toAverage();
                },
                0,
            ],
            [
                [],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterTrue(static function ($value) {
                            return $value > 0;
                        })
                        ->toAverage();
                },
                null,
            ],
            [
                [1, -1, 2, -2, 3, -3],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterTrue(static function ($value) {
                            return $value > 0;
                        })
                        ->toAverage();
                },
                2,
            ],
            [
                [],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterFalse(static function ($value) {
                            return $value > 0;
                        })
                        ->toAverage();
                },
                null,
            ],
            [
                [1, -1, 2, -2, 3, -3],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterFalse(static function ($value) {
                            return $value > 0;
                        })
                        ->toAverage();
                },
                -2,
            ],
            [
                [],
                static function (array $iterable) {
                    return Chain::create($iterable)->toMax();
                },
                null,
            ],
            [
                [1, -1, 2, -2, 3, -3],
                static function (array $iterable) {
                    return Chain::create($iterable)->toMax();
                },
                3,
            ],
            [
                [],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterTrue(static function ($value) {
                            return $value > 0;
                        })
                        ->toMax();
                },
                null,
            ],
            [
                [1, -1, 2, -2, 3, -3],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterTrue(static function ($value) {
                            return $value > 0;
                        })
                        ->toMax();
                },
                3,
            ],
            [
                [],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterFalse(static function ($value) {
                            return $value > 0;
                        })
                        ->toMax();
                },
                null,
            ],
            [
                [1, -1, 2, -2, 3, -3],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterFalse(static function ($value) {
                            return $value > 0;
                        })
                        ->toMax();
                },
                -1,
            ],
            [
                [],
                static function (array $iterable) {
                    return Chain::create($iterable)->toMin();
                },
                null,
            ],
            [
                [1, -1, 2, -2, 3, -3],
                static function (array $iterable) {
                    return Chain::create($iterable)->toMin();
                },
                -3,
            ],
            [
                [],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterTrue(static function ($value) {
                            return $value > 0;
                        })
                        ->toMin();
                },
                null,
            ],
            [
                [1, -1, 2, -2, 3, -3],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterTrue(static function ($value) {
                            return $value > 0;
                        })
                        ->toMin();
                },
                1,
            ],
            [
                [],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterFalse(static function ($value) {
                            return $value > 0;
                        })
                        ->toMin();
                },
                null,
            ],
            [
                [1, -1, 2, -2, 3, -3],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterFalse(static function ($value) {
                            return $value > 0;
                        })
                        ->toMin();
                },
                -3,
            ],
            [
                [],
                static function (array $iterable) {
                    return Chain::create($iterable)->toProduct();
                },
                null,
            ],
            [
                [1, -1, 2, -2, 3, -3],
                static function (array $iterable) {
                    return Chain::create($iterable)->toProduct();
                },
                -36,
            ],
            [
                [],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterTrue(static function ($value) {
                            return $value > 0;
                        })
                        ->toProduct();
                },
                null,
            ],
            [
                [1, -1, 2, -2, 3, -3],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterTrue(static function ($value) {
                            return $value > 0;
                        })
                        ->toProduct();
                },
                6,
            ],
            [
                [],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterFalse(static function ($value) {
                            return $value > 0;
                        })
                        ->toProduct();
                },
                null,
            ],
            [
                [1, -1, 2, -2, 3, -3],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterFalse(static function ($value) {
                            return $value > 0;
                        })
                        ->toProduct();
                },
                -6,
            ],
            [
                [],
                static function (array $iterable) {
                    return Chain::create($iterable)->toSum();
                },
                0,
            ],
            [
                [1, -1, 2, -2, 3, -3],
                static function (array $iterable) {
                    return Chain::create($iterable)->toSum();
                },
                0,
            ],
            [
                [],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterTrue(static function ($value) {
                            return $value > 0;
                        })
                        ->toSum();
                },
                0,
            ],
            [
                [1, -1, 2, -2, 3, -3],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterTrue(static function ($value) {
                            return $value > 0;
                        })
                        ->toSum();
                },
                6,
            ],
            [
                [],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterFalse(static function ($value) {
                            return $value > 0;
                        })
                        ->toSum();
                },
                0,
            ],
            [
                [1, -1, 2, -2, 3, -3],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterFalse(static function ($value) {
                            return $value > 0;
                        })
                        ->toSum();
                },
                -6,
            ],
            [
                [],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->toValue(function ($carry, $item) {
                            return $carry + $item;
                        });
                },
                null,
            ],
            [
                [],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->toValue(function ($carry, $item) {
                            return $carry + $item;
                        }, 1);
                },
                1,
            ],
            [
                [1, -1, 2, -2, 3, -3],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->toValue(function ($carry, $item) {
                            return $carry + $item;
                        });
                },
                0,
            ],
            [
                [1, -1, 2, -2, 3, -3],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->toValue(function ($carry, $item) {
                            return $carry + $item;
                        }, 1);
                },
                1,
            ],
            [
                [],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterTrue(static function ($value) {
                            return $value > 0;
                        })
                        ->toValue(function ($carry, $item) {
                            return $carry + $item;
                        });
                },
                null,
            ],
            [
                [],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterTrue(static function ($value) {
                            return $value > 0;
                        })
                        ->toValue(function ($carry, $item) {
                            return $carry + $item;
                        }, 1);
                },
                1,
            ],
            [
                [1, -1, 2, -2, 3, -3],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterTrue(static function ($value) {
                            return $value > 0;
                        })
                        ->toValue(function ($carry, $item) {
                            return $carry + $item;
                        });
                },
                6,
            ],
            [
                [1, -1, 2, -2, 3, -3],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterTrue(static function ($value) {
                            return $value > 0;
                        })
                        ->toValue(function ($carry, $item) {
                            return $carry + $item;
                        }, 1);
                },
                7,
            ],
            [
                [],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterFalse(static function ($value) {
                            return $value > 0;
                        })
                        ->toValue(function ($carry, $item) {
                            return $carry + $item;
                        });
                },
                null,
            ],
            [
                [],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterFalse(static function ($value) {
                            return $value > 0;
                        })
                        ->toValue(function ($carry, $item) {
                            return $carry + $item;
                        }, 1);
                },
                1,
            ],
            [
                [1, -1, 2, -2, 3, -3],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterFalse(static function ($value) {
                            return $value > 0;
                        })
                        ->toValue(function ($carry, $item) {
                            return $carry + $item;
                        });
                },
                -6,
            ],
            [
                [1, -1, 2, -2, 3, -3],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->filterFalse(static function ($value) {
                            return $value > 0;
                        })
                        ->toValue(function ($carry, $item) {
                            return $carry + $item;
                        }, 1);
                },
                -5,
            ],
            [
                [1, 2, 3],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->zipWith(
                            [10, 20, 30],
                            [100, 200, 300]
                        )
                        ->toValue(function ($carry, $item) {
                            return $carry + array_sum($item);
                        }, 0);
                },
                666,
            ],
            [
                [1, 2, 3],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->zipEqualWith(
                            [10, 20, 30],
                            [100, 200, 300]
                        )
                        ->toValue(function ($carry, $item) {
                            return $carry + array_sum($item);
                        }, 0);
                },
                666,
            ],
            [
                [1, 2, 3, 4, 5],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->zipWith(
                            [10, 20, 30],
                            [100, 200, 300]
                        )
                        ->toValue(function ($carry, $item) {
                            return $carry + array_sum($item);
                        }, 0);
                },
                666,
            ],
            [
                [1, 2, 3, 4, 5],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->zipLongestWith(
                            [10, 20, 30],
                            [100, 200, 300]
                        )
                        ->toValue(function ($carry, $item) {
                            return $carry + array_sum($item);
                        }, 0);
                },
                675,
            ],
            [
                [1, 2, 3],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->chainWith(
                            [4, 5, 6],
                            [7, 8, 9]
                        )
                        ->toSum();
                },
                45,
            ],
            [
                [1, 2, 3],
                static function (array $iterable) {
                    return Chain::create($iterable)
                        ->chainWith(
                            [4, 5, 6],
                            [7, 8, 9]
                        )
                        ->zipEqualWith([1, 2, 3, 4, 5, 6, 7, 8, 9])
                        ->toValue(static function ($carry, $item) {
                            return $carry + array_sum($item);
                        });
                },
                90,
            ],
        ];
    }
}
