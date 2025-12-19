<?php

namespace TmdbApi\Factory;

use DateTimeImmutable;
use Generic\GenericCollection;
use TmdbApi\Dto\CastDto;
use TmdbApi\Dto\CrewDto;
use TmdbApi\Dto\GenreDto;
use TmdbApi\Dto\ImageDto;
use TmdbApi\Dto\MovieDto;
use TmdbApi\Dto\VideoDto;

class MovieFactory
{
    public function __construct(
        private readonly GenreFactory $genreFactory,
        private readonly ImageFactory $imageFactory,
        private readonly CastFactory  $castFactory,
        private readonly CrewFactory  $crewFactory,
        private readonly VideoFactory $videoFactory,
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
        $logos = $this->getLogos($data);
        $videos = $this->getVideos($data);

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
            $logos,
            $videos,
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
        foreach ($data['credits']['cast'] ?? [] as $castData) {
            $cast->add($this->castFactory->createFromData($castData));
        }

        return $cast;
    }

    private function getCrew(array $data): GenericCollection
    {
        $crew = new GenericCollection(CrewDto::class);
        foreach ($data['credits']['crew'] ?? [] as $crewData) {
            $crew->add($this->crewFactory->createFromData($crewData));
        }

        return $crew;
    }

    private function getLogos(array $data): GenericCollection
    {
        $logos = new GenericCollection(ImageDto::class);
        foreach ($data['images']['logos'] ?? [] as $logoData) {
            $logos->add($this->imageFactory->createFromData($logoData));
        }

        return $logos;
    }

    private function getVideos(array $data): GenericCollection
    {
        $videos = new GenericCollection(VideoDto::class);
        foreach ($data['videos']['results'] ?? [] as $videoData) {
            $videos->add($this->videoFactory->createFromData($videoData));
        }

        return $videos;
    }
}
