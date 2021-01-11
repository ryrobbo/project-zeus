<?php declare(strict_types=1);

namespace Zeus\Parsers;

use Zeus\Parsers\Elements\Anchors\ParsesAnchors;

class ParseInternalLinks implements ParsesHtmlLinks
{
    private ParsesAnchors $linkParser;

    public function __construct(ParsesAnchors $parseAnchors)
    {
        $this->linkParser = $parseAnchors;
    }

    public function parse(DescribesWebsite $website, string $html): array
    {
        $document = new \DOMDocument();

        libxml_use_internal_errors(true);
        $document->loadHTML($html);
        libxml_clear_errors();

        return $this->linkParser->parseAnchors($website->getDomain(), $document);
    }
}
