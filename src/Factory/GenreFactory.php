<?php

namespace TmdbApi\Factory;

use TmdbApi\Dto\GenreDto;

class GenreFactory
{
    public function createFromId(int $id): GenreDto
    {
        return new GenreDto($id);
    }

    public function createFromData(array $data): GenreDto
    {
        return new GenreDto(
            $data['id'],
            $data['name'],
        );
    }
}