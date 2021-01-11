<?php

namespace Tests\Unit\Parsers;

use PHPUnit\Framework\TestCase;
use Zeus\Parsers\Elements\Anchors\HasSamePageAnchorValidator;
use Zeus\Parsers\Elements\Anchors\IsAnchorToMediaResourceValidator;
use Zeus\Parsers\Website;
use Zeus\Parsers\ParseInternalLinks;
use Zeus\Parsers\Elements\Anchors\InternalAnchors;

class CrawledHtmlParserTest extends TestCase
{
    public function testGetLinksReturnsAnArray(): void
    {
        $website = new Website('ryrobbo.com', 'http');
        $linkParser = new InternalAnchors([
            new IsAnchorToMediaResourceValidator(),
            new HasSamePageAnchorValidator()
        ]);
        $parser = new ParseInternalLinks($linkParser);

        $links = $parser->parse($website, '<html></html>');

        $this->assertIsArray($links);
    }
}
