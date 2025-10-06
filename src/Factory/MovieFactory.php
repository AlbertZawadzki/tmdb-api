<?php

namespace TmdbApi\Factory;

use DateTimeImmutable;
use TmdbApi\Dto\CollectionDto;
use TmdbApi\Dto\GenreDto;
use TmdbApi\Dto\MovieDto;

class MovieFactory
{
    public function __construct(
        private readonly GenreFactory $genreFactory,
    )
    {
    }

    public function createFromData(array $data): MovieDto
    {
        $title = trim($data['title']);
        $originalTitle = trim($data['original_title']);
        $shortDescription = trim($data['overview']);
        $posterPath = $this->getImagePath($data['poster_path'] ?? null);
        $backdropPath = $this->getImagePath($data['backdrop_path'] ?? null);
        $votesCount = $data['vote_count'];
        $averageVote = $data['vote_average'];
        $votesSum = (int)($votesCount * $averageVote);
        $runtime = (int)$data['runtime'] ?? 0;
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

    private function getGenres(array $data): CollectionDto
    {
        $genres = new CollectionDto(GenreDto::class);
        foreach ($data['genre_ids'] ?? [] as $genreId) {
            $genres->add($this->genreFactory->createFromId($genreId));
        }
        foreach ($data['genres'] ?? [] as $genreData) {
            $genres->add($this->genreFactory->createFromData($genreData));
        }

        return $genres;
    }

    private function getImagePath(?string $path): ?string
    {
        if ($path) {
            return "https://image.tmdb.org/t/p/original{$path}";
        }

        return null;
    }
}