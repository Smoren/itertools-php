<?php

namespace IterTools\SolutionFinder;

class TypeCoercer
{
    public static function coerceReturnType(string $type): array
    {
        switch ($type) {
            case 'int':
            case 'integer':
            case 'float':
            case 'double':
                return ['numeric'];
            case 'self':
            case 'array':
            case 'bool':
            case 'boolean':
            case 'string':
                return [$type];
            case 'mixed':
                return ['numeric', 'array', 'bool', 'string'];
            default:
                return [];
        }
    }

    public static function coerceParamType(string $type): array
    {
        switch ($type) {
            case 'int':
            case 'integer':
            case 'float':
            case 'double':
                return ['numeric'];
            case 'mixed':
                return ['numeric', 'array', 'bool', 'string'];
            default:
                return [$type];
        }
    }
}