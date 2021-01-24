<?php

namespace Tests\Unit\Parsers;

use PHPUnit\Framework\TestCase;
use Zeus\Parsers\Website;

class WebsiteTest extends TestCase
{
    public function testGettersReturnExpectedValues(): void
    {
        $website = new Website('http', 'ryrobbo.com');

        $this->assertEquals('ryrobbo.com', $website->getDomain());
        $this->assertEquals('http', $website->getProtocol());
        $this->assertEquals('http://ryrobbo.com', $website->getDomainUrl());
    }

    public function testCanSetWebsiteStartUrl(): void
    {
        $website = new Website('http', 'ryrobbo.com');

        $this->assertEquals('/', $website->getStartUrl());

        $website->setStartUrl('/index');

        $this->assertEquals('/index', $website->getStartUrl());
    }
}
