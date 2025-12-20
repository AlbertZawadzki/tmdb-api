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
        public readonly ?string            $title = null,
        public readonly ?string            $originalTitle = null,
        public readonly ?string            $overview = null,
        public readonly ?string            $tagline = null,
        public readonly ?ImageDto          $posterImage = null,
        public readonly ?ImageDto          $backdropImage = null,
        public readonly ?int               $votesCount = null,
        public readonly ?int               $votesSum = null,
        public readonly ?bool              $isAdult = null,
        public readonly ?DateTimeImmutable $releaseAt = null,
        public readonly GenericCollection  $genres = new GenericCollection(GenreDto::class),
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