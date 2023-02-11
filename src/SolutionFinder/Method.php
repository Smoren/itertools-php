<?php

namespace IterTools\SolutionFinder;

class Method
{
    /**
     * @var string
     */
    public string $name;
    /**
     * @var array<string>
     */
    public array $types;
    /**
     * @var array<array<string, string>>
     */
    public array $params;

    /**
     * @param string $name
     * @param array<string> $types
     * @param array<string> $params
     */
    public function __construct(string $name, array $types, array $params)
    {
        $this->name = $name;
        $this->types = $types;
        $this->params = $params;
    }

    public function getParamTypes(): array
    {
        $result = [];
        foreach ($this->params as $types) {
            $result = [...$result, ...array_values($types)];
        }
        return $result;
    }
}
