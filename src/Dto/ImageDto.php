<?php

namespace TmdbApi\Dto;

class ImageDto
{
    public function __construct(
        public readonly ?string $path = null,
        public readonly ?string $url = null,
    )
    {
    }
}