<?php

namespace TmdbApi\Factory;

use TmdbApi\Dto\CrewDto;

class CrewFactory
{
    public function __construct(
        private readonly PersonFactory $personFactory,
    )
    {
    }

    public function createFromData(array $data): CrewDto
    {
        $person = $this->personFactory->createFromData($data);

        return new CrewDto(
            $person,
            $data['job'],
        );
    }
}