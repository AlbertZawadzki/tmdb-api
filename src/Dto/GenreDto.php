<?php

namespace TmdbApi\Dto;

class GenreDto
{
    public function __construct(
        public readonly string  $id,
        public readonly ?string $name = null,
    )
    {
    }
}