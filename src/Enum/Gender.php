<?php

namespace TmdbApi\Enum;

enum Gender: string
{
    case MALE = 'male';
    case FEMALE = 'female';

    public static function tryFromTmdbGender(?int $genderId): ?Gender
    {
        return match ($genderId) {
            1 => Gender::FEMALE,
            2 => Gender::MALE,
            default => null,
        };
    }
}