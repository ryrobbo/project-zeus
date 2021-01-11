<?php

namespace Zeus\Parsers;

interface ParsesHtmlLinks
{
    public function parse(DescribesWebsite $website, string $html): array;
}
