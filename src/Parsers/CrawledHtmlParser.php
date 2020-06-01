<?php

namespace Zeus\Parsers;

use Zeus\Parsers\Contracts\DescribesWebsite;
use Zeus\Parsers\Contracts\ParsesHtmlDocuments;
use Zeus\Parsers\Elements\Contracts\ParsesAnchors;

class CrawledHtmlParser implements ParsesHtmlDocuments
{
    /** @var \DOMDocument */
    private $domDocument;

    private DescribesWebsite $manifest;

    private ParsesAnchors $linkParser;

    public function __construct(
        DescribesWebsite $website,
        ParsesAnchors $parseAnchors
    )
    {
        $this->manifest = $website;
        $this->linkParser = $parseAnchors;
    }

    public function loadHtml(string $html): void
    {
        $document = new \DOMDocument();

        libxml_use_internal_errors(true);
        $document->loadHTML($html);
        libxml_clear_errors();

        $this->domDocument = $document;
    }

    public function getLinks(): array
    {
        return $this->linkParser->parseAnchors($this->manifest->getDomain(), $this->domDocument);
    }

}
