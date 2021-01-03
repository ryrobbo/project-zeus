<?php

namespace Zeus\Parsers\Elements\Anchors;

interface ValidatesInternalAnchor
{
    public function validate(string $link): bool;
}
