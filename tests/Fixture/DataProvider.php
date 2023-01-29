<?php

namespace IterTools\Tests\Fixture;

use IterTools\Infinite;
use IterTools\Math;
use IterTools\Multi;
use IterTools\Random;
use IterTools\Set;
use IterTools\Single;
use IterTools\Tests\Fixture;

trait DataProvider
{
    public function dataProviderForEmptyIterable(): array
    {
        return [
            [[]],
            [Fixture\GeneratorFixture::getGenerator([])],
            [new Fixture\ArrayIteratorFixture([])],
            [new Fixture\IteratorAggregateFixture([])],
        ];
    }

    public function dataProviderForIterableLoopTools(): \Generator
    {
        foreach ($this->dataProviderForMultiLoopTools() as $loopTool) {
            yield $loopTool;
        }
        foreach ($this->dataProviderForSingleLoopTools() as $loopTool) {
            yield $loopTool;
        }
        foreach ($this->dataProviderForInfiniteLoopTools() as $loopTool) {
            yield $loopTool;
        }
        foreach ($this->dataProviderForRandomLoopTools() as $loopTool) {
            yield $loopTool;
        }
        foreach ($this->dataProviderForMathLoopTools() as $loopTool) {
            yield $loopTool;
        }
        foreach ($this->dataProviderForSetLoopTools() as $loopTool) {
            yield $loopTool;
        }
    }

    public function dataProviderForMultiLoopTools(): array
    {
        return [
            [Multi::chain([1, 2, 3], [4, 5, 6])],
            [Multi::zip([1, 2, 3], [4, 5, 6])],
            [Multi::zipLongest([1, 2, 3], [4, 5, 6])],
            [Multi::zipEqual([1, 2, 3], [4, 5, 6])],
        ];
    }

    public function dataProviderForSingleLoopTools(): array
    {
        return [
            [Single::chunkwise([1, 2, 3, 4, 5], 2)],
            [Single::chunkwiseOverlap([1, 2, 3, 4, 5], 2, 1)],
            [Single::compress([1, 2, 3, 4, 5], [1, 1, 0, 0, 1])],
            [Single::dropWhile([1, 2, 3, 4, 5], fn ($x) => $x < 2)],
            [Single::filterTrue([1, 2, 3, 4, 5], fn ($x) => $x < 2)],
            [Single::filterFalse([1, 2, 3, 4, 5], fn ($x) => $x < 2)],
            [Single::groupBy([1, 2, 3, 4, 5], fn ($x) => $x < 2)],
            [Single::limit([1, 2, 3, 4, 5], 3)],
            [Single::map([1, 2, 3, 4, 5], fn ($x) => $x ** 2)],
            [Single::pairwise([1, 2, 3, 4, 5])],
            [Single::repeat(10, 5)],
            [Single::string('abcdefg')],
            [Single::takeWhile([1, 2, 3, 4, 5], fn ($x) => $x < 2)],
        ];
    }

    public function dataProviderForInfiniteLoopTools(): array
    {
        return [
            [Infinite::count(1, 1)],
            [Infinite::cycle([1, 2, 3])],
            [Infinite::repeat(5)],

        ];
    }

    public function dataProviderForRandomLoopTools(): array
    {
        return [
            [Random::choice([1, 2, 3], 3)],
            [Random::coinFlip(5)],
            [Random::number(1, 10, 5)],
            [Random::percentage(5)],
            [Random::rockPaperScissors(5)],
        ];
    }

    public function dataProviderForMathLoopTools(): array
    {
        return [
            [Math::runningAverage([1, 2, 3, 4, 5])],
            [Math::runningDifference([1, 2, 3, 4, 5])],
            [Math::runningMax([1, 2, 3, 4, 5])],
            [Math::runningMin([1, 2, 3, 4, 5])],
            [Math::runningProduct([1, 2, 3, 4, 5])],
            [Math::runningTotal([1, 2, 3, 4, 5])],
        ];
    }

    public function dataProviderForSetLoopTools(): array
    {
        return [
            [Set::distinct([1, 2, 3, 4, 5])],
            [Set::intersection([1, 2, 3, 4, 5], [2, 3, 4])],
            [Set::intersectionCoercive([1, 2, 3, 4, 5], [2, 3, 4])],
            [Set::partialIntersection(2, [1, 2, 3, 4, 5], [2, 3, 4])],
            [Set::partialIntersectionCoercive(2, [1, 2, 3, 4, 5], [2, 3, 4])],
            [Set::symmetricDifference([1, 2, 3, 4, 5], [2, 3, 4])],
            [Set::symmetricDifferenceCoercive([1, 2, 3, 4, 5], [2, 3, 4])],
        ];
    }
}
