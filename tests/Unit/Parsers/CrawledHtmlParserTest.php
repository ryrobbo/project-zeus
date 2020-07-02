<?php

namespace Tests\Unit\Parsers;

use PHPUnit\Framework\TestCase;
use Zeus\Parsers\Website;
use Zeus\Parsers\CrawledHtmlParser;
use Zeus\Parsers\Elements\InternalAnchors;
use Zeus\Parsers\ParserMissingHtmlException;

class CrawledHtmlParserTest extends TestCase
{
    public function testExceptionIsThrownIfDomDocumentHasNotBeenLoaded(): void
    {
        $this->expectException(ParserMissingHtmlException::class);

        $website = new Website('ryrobbo.com', 'http');
        $linkParser = new InternalAnchors();
        $parser = new CrawledHtmlParser($website, $linkParser);

        $links = $parser->getLinks();
    }

    public function testGetLinksReturnsAnArray(): void
    {
        $website = new Website('ryrobbo.com', 'http');
        $linkParser = new InternalAnchors();
        $parser = new CrawledHtmlParser($website, $linkParser);

        $parser->loadHtml('<html></html>');
        $links = $parser->getLinks();

        $this->assertIsArray($links);
    }
}