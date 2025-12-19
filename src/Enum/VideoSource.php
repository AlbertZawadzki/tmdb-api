<?php

namespace TmdbApi\Enum;

enum VideoSource: string
{
    case UNKNOWN = 'unknown';
    case YOUTUBE = 'youtube';
    case VIMEO = 'vimeo';

    public static function tryFromTmdbType(?string $type): ?VideoSource
    {
        $type ??= "";
        $type = strtolower($type);

        return match ($type) {
            'youtube' => VideoSource::YOUTUBE,
            'vimeo' => VideoSource::VIMEO,
            default => VideoType::UNKNOWN,
        };
    }
}