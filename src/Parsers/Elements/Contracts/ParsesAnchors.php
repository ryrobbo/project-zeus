<?php

namespace Zeus\Parsers\Elements\Contracts;

interface ParsesAnchors
{
    public function parseAnchors(string $domain, \DOMDocument $document): array;
}
