<?php

namespace TmdbApi\Dto;

class CrewDto
{
    public function __construct(
        public readonly PersonDto $person,
        public readonly string    $job,
    )
    {
    }
}