<?php

namespace TmdbApi\Dto;

use DateTimeImmutable;
use Generic\GenericCollection;

class MovieDto
{
    /**
     * @param GenericCollection<GenreDto> $genres
     */
    public function __construct(
        public readonly string             $id,
        public readonly string             $title,
        public readonly string             $originalTitle,
        public readonly string             $shortDescription,
        public readonly ?string            $posterPath,
        public readonly ?string            $backdropPath,
        public readonly int                $votesCount,
        public readonly int                $votesSum,
        public readonly ?int               $runtime,
        public readonly bool               $isAdult,
        public readonly ?DateTimeImmutable $premiereAt,
        public readonly GenericCollection  $genres,
    )
    {
    }
}