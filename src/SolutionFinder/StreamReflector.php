<?php

declare(strict_types=1);

namespace IterTools\SolutionFinder;

use IterTools\Stream;

class StreamReflector
{
    public function __construct()
    {
        $class = new \ReflectionClass(Stream::class);
        $map = [];

        foreach ($class->getMethods() as $method) {
            if ($method->isConstructor()) {
                continue;
            }

            if ($method->isStatic()) {
                continue;
            }

            $types = $this->getTypes($method);

            foreach ($types as $type) {
                if (!isset($map[$type])) {
                    $map[$type] = [];
                }
                $map[$type][] = $method->getName();
            }
        }
    }

    protected function getTypes(\ReflectionMethod $method): array
    {
        $type = $method->getReturnType();

        if ($type !== null) {
            return $this->coerceType($type->getName());
        }

        preg_match('/@return +([A-Za-z0-9_\|<>]+)/', $method->getDocComment(), $matches);
        $typeString = $matches[1];

        $result = [];
        foreach (explode('|', $typeString) as $type) {
            $result = [...$result, ...$this->coerceType(trim($type))];
        }
        return $result;
    }

    protected function coerceType(string $type): array
    {
        switch ($type) {
            case 'int':
            case 'float':
                return ['numeric'];
            case 'self':
            case 'array':
            case 'bool':
            case 'string':
                return [$type];
            case 'mixed':
                return ['numeric', 'array', 'bool', 'string'];
            default:
                return [];
        }
    }
}