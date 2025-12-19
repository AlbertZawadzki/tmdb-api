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

    public function createFromData(array $data): ImageDto
    {
        $path = $data['file_path'] ?? null;
        $url = null;
        if ($path) {
            $url = "https://image.tmdb.org/t/p/original{$path}";
        }

        return new ImageDto(
            $path,
            $url,
            $data['width'] ?? null,
            $data['height'] ?? null,
        );
    }
}
