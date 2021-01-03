<?php

namespace Zeus\Parsers\Elements\Anchors;

interface ParsesAnchors
{
    public function parseAnchors(string $domain, \DOMDocument $document): array;
}
