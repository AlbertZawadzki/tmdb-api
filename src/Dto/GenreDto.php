<?php

namespace TmdbApi\Dto;

class GenreDto
{
    public function __construct(
        private readonly string  $id,
        private readonly ?string $name = null,
    )
    {
    }
}