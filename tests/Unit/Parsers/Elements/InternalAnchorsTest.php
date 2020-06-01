<?php

namespace Tests\Unit\Parsers\Elements;

use PHPUnit\Framework\TestCase;
use Zeus\Parsers\Elements\InternalAnchors;

class InternalAnchorsTest extends TestCase
{
    /** @test */
    public function only_unique_internal_links_are_extracted()
    {
        $html = file_get_contents(__DIR__ . '/../../../__sample_html__/ryrobbo-internal-links.html');

        $document = new \DOMDocument();
        libxml_use_internal_errors(true);
        $document->loadHTML($html);
        libxml_clear_errors();

        $parser = new InternalAnchors();

        $links = $parser->parseAnchors('ryrobbo.com', $document);

        $this->assertEquals(7, count($links));
    }
}
