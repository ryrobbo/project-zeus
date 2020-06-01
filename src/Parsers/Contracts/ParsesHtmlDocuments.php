<?php

namespace Zeus\Parsers\Contracts;

interface ParsesHtmlDocuments
{
    public function loadHtml(string $html): void;

    public function getLinks(): array;
}
