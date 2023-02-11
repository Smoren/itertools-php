<?php

namespace IterTools\SolutionFinder;

class Configurator
{
    /**
     * @var non-empty-array<array<mixed>>
     */
    protected array $expected;
    /**
     * @var non-empty-array<mixed>
     */
    protected array $input;

    /**
     * @param non-empty-array<array<mixed>> $expected
     * @param non-empty-array<mixed> $input
     */
    public function __construct(array $input, array $expected)
    {
        $this->expected = $expected;
        $this->input = $input;

        $reflector = new StreamReflector();

        $expectedType = TypeCoercer::coerceReturnType(\gettype($this->expected[0]))[0];

        $terminalMethods = $reflector->getMethods($expectedType);

        $a = 1;
    }
}
