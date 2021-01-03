<?php

namespace Tests\Unit\Parsers\Elements\Anchors;

use PHPUnit\Framework\TestCase;
use Zeus\Parsers\Elements\Anchors\HasSamePageAnchorValidator;
use Zeus\Parsers\Elements\Anchors\InternalAnchors;
use Zeus\Parsers\Elements\Anchors\IsAnchorToMediaResourceValidator;

class InternalAnchorsTest extends TestCase
{
    public function testOnlyUniqueInternalLinksAreExtracted(): void
    {
        $html = file_get_contents(__DIR__ . '/../../../../__sample_html__/ryrobbo-internal-links.html');

        $document = new \DOMDocument();
        libxml_use_internal_errors(true);
        $document->loadHTML($html);
        libxml_clear_errors();

        $parser = new InternalAnchors([
            new IsAnchorToMediaResourceValidator(),
            new HasSamePageAnchorValidator()
        ]);

        $links = $parser->parseAnchors('ryrobbo.com', $document);

        $this->assertEquals(7, count($links));

        $this->assertTrue(in_array('/page/about', $links));
        $this->assertTrue(in_array('/page/contact', $links));
        $this->assertTrue(in_array('/category/zend-framework-2', $links));
    }
}
