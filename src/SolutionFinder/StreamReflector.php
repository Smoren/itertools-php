<?php

declare(strict_types=1);

namespace IterTools\SolutionFinder;

use IterTools\Stream;
use PHPStan\BetterReflection\Reflection\ReflectionMethod;

class StreamReflector
{
    /**
     * @var array<mixed>
     */
    protected array $map = [];

    public function __construct()
    {
        $class = new \ReflectionClass(Stream::class);
        $excludeMethodsByName = ['infiniteCycle'];
        $excludeMethodsByParamTypes = ['array', 'iterable'];

        $this->map = Stream::of($class->getMethods())
            ->filterFalse(fn (\ReflectionMethod $m) => $m->isConstructor() || $m->isStatic())
            ->filterFalse(fn (\ReflectionMethod $m) => in_array($m->getName(), $excludeMethodsByName))
            ->map(fn (\ReflectionMethod $m) => $this->getMethod($m))
            ->filterFalse(fn (Method $m) => count(array_intersect($m->getParamTypes(), $excludeMethodsByParamTypes)))
            ->groupBy(fn (Method $m) => $m->types, fn (Method $m) => $m->name)
            ->toAssociativeArray();
    }

    public function getMethods(string $type): array
    {
        return $this->map[$type] ?? [];
    }

    protected function getMethod(\ReflectionMethod $method): Method
    {
        $name = $method->getName();
        $types = $this->getTypes($method);
        $params = Stream::of($method->getParameters())
            ->reindex(fn (\ReflectionParameter $p) => $p->getName())
            ->map(fn (\ReflectionParameter $p) => $this->getParamTypes($p, $method))
            ->toAssociativeArray();

        return new Method($name, $types, $params);
    }

    protected function getParamTypes(\ReflectionParameter $param, \ReflectionMethod $method): array
    {
        $type = $param->getType();

        if ($type !== null) {
            return TypeCoercer::coerceParamType($type->getName());
        }

        preg_match("/([A-Za-z0-9_\|<>]+) +[\\$]{$param->getName()}/", $method->getDocComment(), $matches);
        $typeString = $matches[1];

        $result = [];
        foreach (explode('|', $typeString) as $type) {
            $result = [...$result, ...TypeCoercer::coerceParamType(trim($type))];
        }
        return $result;
    }

    protected function getTypes(\ReflectionMethod $method): array
    {
        $type = $method->getReturnType();

        if ($type !== null) {
            return TypeCoercer::coerceReturnType($type->getName());
        }

        preg_match('/@return +([A-Za-z0-9_\|<>]+)/', $method->getDocComment(), $matches);
        $typeString = $matches[1];

        $result = [];
        foreach (explode('|', $typeString) as $type) {
            $result = [...$result, ...TypeCoercer::coerceReturnType(trim($type))];
        }
        return $result;
    }
}