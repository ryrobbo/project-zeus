<?php

namespace Tests\Unit\Parsers;

use PHPUnit\Framework\TestCase;
use Zeus\Parsers\Website;
use Zeus\Parsers\CrawledHtmlParser;
use Zeus\Parsers\Elements\InternalAnchors;
use Zeus\Parsers\ParserMissingHtmlException;

class CrawledHtmlParserTest extends TestCase
{
    /** @test */
    public function exception_is_thrown_if_dom_document_has_not_been_loaded(): void
    {
        $this->expectException(ParserMissingHtmlException::class);

        $website = new Website('ryrobbo.com', 'http');
        $linkParser = new InternalAnchors();
        $parser = new CrawledHtmlParser($website, $linkParser);

        $links = $parser->getLinks();
    }

    /** @test */
    public function get_links_returns_an_array(): void
    {
        $website = new Website('ryrobbo.com', 'http');
        $linkParser = new InternalAnchors();
        $parser = new CrawledHtmlParser($website, $linkParser);

        $parser->loadHtml('<html></html>');
        $links = $parser->getLinks();

        $this->assertIsArray($links);
    }
}
