<?php declare(strict_types=1);

namespace Zeus\Parsers\Elements\Anchors;

class IsAnchorToMediaResourceValidator implements ValidatesInternalAnchor
{
    private const MEDIA_EXTENSIONS = [
        'png',
        'jpg',
        'jpeg',
        'gif',
        'svg',
        'mp3',
        'mp4',
    ];

    public function validate(string $link): bool
    {
        if (strpos($link, '.') === false) {
            return false;
        }

        $extension = strtolower(
            substr(
                explode('.', $link)[1],
                0,
                4
            )
        );

        return in_array($extension, self::MEDIA_EXTENSIONS);
    }
}
