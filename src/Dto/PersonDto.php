<?php

namespace TmdbApi\Dto;

use TmdbApi\Enum\Gender;

class PersonDto
{
    public function __construct(
        public readonly string   $id,
        public readonly ImageDto $image,
        public readonly ?string  $name = null,
        public readonly ?string  $originalName = null,
        public readonly ?Gender  $gender = null,
        public readonly ?bool    $isAdult = null,
    )
    {
    }
}