<?php

namespace TmdbApi\Dto;

use ArrayIterator;
use IteratorAggregate;
use RuntimeException;
use Traversable;

/**
 * @template T of object
 * @implements IteratorAggregate<int, T>
 */
class CollectionDto implements IteratorAggregate
{
    /** @var array<int, T> */
    private array $items = [];

    /**
     * @param class-string<T> $itemClass
     */
    public function __construct(
        private readonly string $itemClass,
    )
    {
    }

    /**
     * @param T $item
     * @return $this
     */
    public function add(mixed $item): static
    {
        if (!$item instanceof $this->itemClass) {
            throw new RuntimeException(sprintf("Wrong class given %s expected %s", $item::class, $this->itemClass));
        }

        $this->items[] = $item;

        return $this;
    }

    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @return Traversable<int, T>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }
}