<?php

namespace TmdbApi\Enum;

enum VideoType: string
{
    case UNKNOWN = 'unknown';
    case BEHIND_SCENES = 'behind_scenes';
    case FEATURETTE = 'featurette';
    case TRAILER = 'trailer';
    case CLIP = 'clip';
    case TEASER = 'teaser';

    public static function tryFromTmdbType(?string $type): ?VideoType
    {
        $type ??= "";
        $type = strtolower($type);

        return match ($type) {
            'behind the scenes' => VideoType::BEHIND_SCENES,
            'featurette' => VideoType::FEATURETTE,
            'trailer' => VideoType::TRAILER,
            'clip' => VideoType::CLIP,
            'teaser' => VideoType::TEASER,
            default => VideoType::UNKNOWN,
        };
    }
}