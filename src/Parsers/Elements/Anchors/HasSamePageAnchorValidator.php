<?php declare(strict_types=1);

namespace Zeus\Parsers\Elements\Anchors;

class HasSamePageAnchorValidator implements ValidatesInternalAnchor
{
    public function validate(string $link): bool
    {
        return strpos($link, '#') !== false;
    }
}
