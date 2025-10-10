<?php

namespace TmdbApi\Factory;

use DateTimeImmutable;
use Generic\GenericCollection;
use TmdbApi\Dto\GenreDto;
use TmdbApi\Dto\MovieDto;

class MovieFactory
{
    public function __construct(
        private readonly GenreFactory $genreFactory,
        private readonly ImageFactory $imageFactory,
    )
    {
    }

    public function createFromData(array $data): MovieDto
    {
        $title = trim($data['title']);
        $originalTitle = trim($data['original_title']);
        $shortDescription = trim($data['overview']);
        $posterPath = $this->imageFactory->createFromPath($data['poster_path'] ?? null);
        $backdropPath = $this->imageFactory->createFromPath($data['backdrop_path'] ?? null);
        $votesCount = $data['vote_count'];
        $averageVote = $data['vote_average'];
        $votesSum = (int)($votesCount * $averageVote);
        $runtime = (int)($data['runtime'] ?? 0);
        if ($runtime === 0) {
            $runtime = null;
        }
        $premiereAt = null;
        if ($data['release_date']) {
            $premiereAt = new DateTimeImmutable($data['release_date']);
        }

        $genres = $this->getGenres($data);

        return new MovieDto(
            $data['id'],
            $title,
            $originalTitle,
            $shortDescription,
            $posterPath,
            $backdropPath,
            $votesCount,
            $votesSum,
            $runtime,
            $data['adult'],
            $premiereAt,
            $genres,
        );
    }

    private function getGenres(array $data): GenericCollection
    {
        $genres = new GenericCollection(GenreDto::class);
        foreach ($data['genre_ids'] ?? [] as $genreId) {
            $genres->add($this->genreFactory->createFromId($genreId));
        }
        foreach ($data['genres'] ?? [] as $genreData) {
            $genres->add($this->genreFactory->createFromData($genreData));
        }

        return $genres;
    }
}
