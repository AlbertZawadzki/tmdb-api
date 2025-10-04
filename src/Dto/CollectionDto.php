<?php

namespace TmdbApi\Dto;

use RuntimeException;

class CollectionDto
{
    private array $items = [];

    public function __construct(
        private readonly string $itemClass,
    )
    {
    }

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

    private function getAll(): array
    {
        return $this->items;
    }
}