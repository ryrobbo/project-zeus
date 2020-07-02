<?php

namespace Tests\Integration\Crawlers;

use Zeus\Parsers\Website;
use Zeus\Browser\Browserless;
use PHPUnit\Framework\TestCase;
use Zeus\Crawlers\CrawlQueueMap;
use Zeus\Crawlers\StandardCrawler;
use Zeus\Parsers\CrawledHtmlParser;
use Zeus\Browser\Clients\RestfulClient;
use Zeus\Parsers\Elements\InternalAnchors;

class StandardCrawlerTest extends TestCase
{
    public function testCrawlerCrawlsTheExpectedUrls(): void
    {
        $website = new Website('ryrobbo.com', 'http');
        $parser = new CrawledHtmlParser($website, new InternalAnchors());
        $queue = new CrawlQueueMap();

        /**
         * Here is where we will
         */
        $browser = $this->getMockBuilder(Browserless::class)
            ->setConstructorArgs([new RestfulClient()])
            ->getMock();

        $page1 = file_get_contents(__DIR__ . '/../../__sample_html__/crawler/page-1.html');
        $page2 = file_get_contents(__DIR__ . '/../../__sample_html__/crawler/page-2.html');
        $page3 = file_get_contents(__DIR__ . '/../../__sample_html__/crawler/page-3.html');
        $page4 = file_get_contents(__DIR__ . '/../../__sample_html__/crawler/page-4.html');
        $page5 = file_get_contents(__DIR__ . '/../../__sample_html__/crawler/page-5.html');
        $page6 = file_get_contents(__DIR__ . '/../../__sample_html__/crawler/page-6.html');

        $browser->method('content')->will(
            $this->onConsecutiveCalls($page1, $page2, $page3, $page4, $page5, $page6)
        );

        $crawler = new StandardCrawler($website, $browser, $parser, $queue);

        $crawledUrls = $crawler->crawl();

        $this->assertEquals(6, count($crawledUrls));

        $this->assertArrayHasKey('/', $crawledUrls);
        $this->assertArrayHasKey('/page/about', $crawledUrls);
        $this->assertArrayHasKey('/page/contact', $crawledUrls);
        $this->assertArrayHasKey('/category/php', $crawledUrls);
        $this->assertArrayHasKey('/category/twitter-bootstrap', $crawledUrls);
        $this->assertArrayHasKey('/category/zend-framework-2', $crawledUrls);
    }
}
