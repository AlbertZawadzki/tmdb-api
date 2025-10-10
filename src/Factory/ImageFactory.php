<?php

namespace TmdbApi\Factory;

use TmdbApi\Dto\ImageDto;

class ImageFactory
{
    public function createFromPath(?string $path): ImageDto
    {
        $url = null;
        if ($path) {
            $url = "https://image.tmdb.org/t/p/original{$path}";
        }

        return new ImageDto(
            $path,
            $url,
        );
    }
}
