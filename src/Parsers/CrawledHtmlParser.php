<?php

namespace Zeus\Parsers;

use Zeus\Parsers\Contracts\HtmlParserContract;

class CrawledHtmlParser implements HtmlParserContract
{
    /** @var \DOMDocument */
    private $domDocument;

    public function __construct(string $html)
    {
        $document = new \DOMDocument();

        libxml_use_internal_errors(true);
        $document->loadHTML($html);
        libxml_clear_errors();

        $this->domDocument = $document;
    }

}
