<?php

namespace TmdbApi\Dto;

class CastDto
{
    public function __construct(
        public readonly PersonDto $person,
        public readonly string    $characterName,
        public readonly ImageDto  $image,
        public readonly int       $displayOrder,
    )
    {
    }
}