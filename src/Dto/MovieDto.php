<?php

namespace TmdbApi\Dto;

use DateTimeImmutable;
use Generic\GenericCollection;

class MovieDto
{
    /**
     * @param GenericCollection<GenreDto> $genres
     * @param GenericCollection<CastDto> $cast
     * @param GenericCollection<CrewDto> $crew
     * @param GenericCollection<ImageDto> $logos
     * @param GenericCollection<VideoDto> $videos
     */
    public function __construct(
        public readonly string             $id,
        public readonly string             $title,
        public readonly string             $originalTitle,
        public readonly string             $overview,
        public readonly ImageDto           $posterImage,
        public readonly ImageDto           $backdropImage,
        public readonly int                $votesCount,
        public readonly int                $votesSum,
        public readonly bool               $isAdult,
        public readonly ?DateTimeImmutable $releaseAt,
        public readonly GenericCollection  $genres,
        public readonly ?int               $runtime = null,
        public readonly ?string            $imdbId = null,
        public readonly GenericCollection  $cast = new GenericCollection(CastDto::class),
        public readonly GenericCollection  $crew = new GenericCollection(CrewDto::class),
        public readonly GenericCollection  $logos = new GenericCollection(ImageDto::class),
        public readonly GenericCollection  $videos = new GenericCollection(VideoDto::class),
    )
    {
    }
}