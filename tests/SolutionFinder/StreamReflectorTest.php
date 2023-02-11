<?php

declare(strict_types=1);

namespace IterTools\Tests\SolutionFinder;

use IterTools\SolutionFinder\Configurator;
use IterTools\SolutionFinder\StreamReflector;

class StreamReflectorTest extends \PHPUnit\Framework\TestCase
{
    public function testFirst(): void
    {
        $input = [
            [1, 2, 3, 4, 5]
        ];
        $expected = [
            [2, 3, 4, 5, 6]
        ];

        $conf = new Configurator($input, $expected);
    }
}
