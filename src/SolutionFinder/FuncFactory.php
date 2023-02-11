<?php

namespace IterTools\SolutionFinder;

class FuncFactory
{
    /**
     * @return array<callable>
     */
    public static function createCollection(): array
    {
        return [
            fn ($x) => $x+1,
            fn ($x) => $x-1,
            fn ($x) => $x*2,
            fn ($x) => $x/2,
            fn ($x) => $x**2,
            fn ($x) => sqrt($x),
            fn ($x) => abs($x),
            fn ($x) => -$x,
        ];
    }
}