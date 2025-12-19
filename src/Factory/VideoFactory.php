<?php

namespace TmdbApi\Factory;

use TmdbApi\Dto\VideoDto;
use TmdbApi\Enum\VideoSource;
use TmdbApi\Enum\VideoType;

class VideoFactory
{
    public function createFromData(array $data): VideoDto
    {
        return new VideoDto(
            VideoType::tryFromTmdbType($data['type']),
            VideoSource::tryFromTmdbType($data['site']),
            $data['key'],
            $data['name'],
            $data['official'],
        );
    }
}
