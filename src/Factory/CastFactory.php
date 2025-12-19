<?php

namespace TmdbApi\Factory;

use TmdbApi\Dto\CastDto;

class CastFactory
{
    public function __construct(
        private readonly PersonFactory $personFactory,
        private readonly ImageFactory  $imageFactory,
    )
    {
    }

    public function createFromData(array $data): CastDto
    {
        $person = $this->personFactory->createFromData($data);
        $image = $this->imageFactory->createFromPath($data['profile_path'] ?? null);

        return new CastDto(
            $person,
            $data['character'],
            $image,
            $data['order'],
        );
    }
}