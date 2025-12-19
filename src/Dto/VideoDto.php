<?php

namespace TmdbApi\Dto;

use TmdbApi\Enum\VideoSource;
use TmdbApi\Enum\VideoType;

class VideoDto
{
    public function __construct(
        public readonly VideoType   $type,
        public readonly VideoSource $source,
        public readonly string      $sourceId,
        public readonly string      $name,
        public readonly bool        $isOfficial,
    )
    {
    }
}