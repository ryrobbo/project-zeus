<?php

namespace Tests\Unit\Crawlers;

use PHPUnit\Framework\TestCase;
use Zeus\Crawlers\CrawlQueueMap;

class CrawlQueueMapTest extends TestCase
{
    /** @test */
    public function can_add_url_to_pending(): void
    {
        $queue = new CrawlQueueMap();

        $queue->addToPending('link-1');
        $queue->addToPending('link-2');
        $queue->addToPending('link-3');

        $pending = $queue->getPendingUrls();

        $this->assertEquals(3, $pending->count());

        $this->assertEquals('link-1', $pending->first()->value);
        $this->assertEquals('link-3', $pending->last()->value);
    }

    /** @test */
    public function can_add_url_to_crawled(): void
    {
        $queue = new CrawlQueueMap();

        $queue->addToCrawled('link-1');
        $queue->addToCrawled('link-2');
        $queue->addToCrawled('link-3');

        $crawled = $queue->getCrawledUrls();

        $this->assertEquals(3, $crawled->count());

        $this->assertEquals('link-1', $crawled->first()->value);
        $this->assertEquals('link-3', $crawled->last()->value);
    }

}
