<?php

namespace TmdbApi\Factory;

use DateTimeImmutable;
use Generic\GenericCollection;
use TmdbApi\Dto\CastDto;
use TmdbApi\Dto\CrewDto;
use TmdbApi\Dto\GenreDto;
use TmdbApi\Dto\MovieDto;

class MovieFactory
{
    public function __construct(
        private readonly GenreFactory $genreFactory,
        private readonly ImageFactory $imageFactory,
        private readonly CastFactory  $castFactory,
        private readonly CrewFactory  $crewFactory,
    )
    {
    }

    public function createFromData(array $data): MovieDto
    {
        $imdbId = $data['imdb_id'] ?? null;
        $title = trim($data['title']);
        $originalTitle = trim($data['original_title']);
        $overview = trim($data['overview']);
        $posterPath = $this->imageFactory->createFromPath($data['poster_path'] ?? null);
        $backdropPath = $this->imageFactory->createFromPath($data['backdrop_path'] ?? null);
        $votesCount = $data['vote_count'];
        $averageVote = $data['vote_average'];
        $votesSum = (int)($votesCount * $averageVote);
        $runtime = (int)($data['runtime'] ?? 0);
        if ($runtime === 0) {
            $runtime = null;
        }
        $releaseAt = null;
        if ($data['release_date']) {
            $releaseAt = new DateTimeImmutable($data['release_date']);
        }

        $genres = $this->getGenres($data);
        $cast = $this->getCast($data);
        $crew = $this->getCrew($data);

        return new MovieDto(
            $data['id'],
            $title,
            $originalTitle,
            $overview,
            $posterPath,
            $backdropPath,
            $votesCount,
            $votesSum,
            $data['adult'],
            $releaseAt,
            $genres,
            $runtime,
            $imdbId,
            $cast,
            $crew,
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

    private function getCast(array $data): GenericCollection
    {
        $cast = new GenericCollection(CastDto::class);
        foreach ($data['genre_ids'] ?? [] as $genreId) {
            $cast->add($this->castFactory->createFromData($genreId));
        }

        return $cast;
    }

    private function getCrew(array $data): GenericCollection
    {
        $crew = new GenericCollection(CrewDto::class);
        foreach ($data['credits']['crew'] ?? [] as $genreId) {
            $crew->add($this->crewFactory->createFromData($genreId));
        }

        return $crew;
    }
}
