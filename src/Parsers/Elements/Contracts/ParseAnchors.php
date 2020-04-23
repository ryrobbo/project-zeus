<?php

namespace Zeus\Parsers\Elements\Contracts;

use Zeus\Parsers\Contracts\DescribesWebsite;

interface ParseAnchors
{
    public function parseAnchors(DescribesWebsite $website, \DOMDocument $document): array;
}
