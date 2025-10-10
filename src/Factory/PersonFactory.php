<?php

namespace TmdbApi\Factory;

use TmdbApi\Dto\PersonDto;
use TmdbApi\Dto\ImageDto;
use TmdbApi\Enum\Gender;

class PersonFactory
{
    public function __construct(
        private readonly ImageFactory $imageFactory,
    )
    {
    }

    public function createFromData(array $data): PersonDto
    {
        $image = $this->imageFactory->createFromPath($data['profile_path'] ?? null);
        $gender = Gender::tryFromTmdbGender($data['gender'] ?? null);

        return new PersonDto(
            $data['id'],
            $image,
            $data['name'],
            $data['original_name'],
            $gender,
            $data['adult'],
        );
    }
}