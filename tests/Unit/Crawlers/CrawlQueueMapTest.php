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

    /** @test */
    public function can_remove_url_from_pending(): void
    {
        $queue = new CrawlQueueMap();

        $queue->addToPending('link-1');
        $queue->addToPending('link-2');
        $queue->addToPending('link-3');

        $pending = $queue->getPendingUrls();

        $this->assertEquals(3, $pending->count());

        $queue->removeFromPending('link-1');
        $queue->removeFromPending('link-2');

        $this->assertEquals(1, $pending->count());

        $this->assertEquals('link-3', $pending->first()->value);
        $this->assertEquals('link-3', $pending->last()->value);
    }

    /** @test */
    public function can_check_url_is_already_pending(): void
    {
        $queue = new CrawlQueueMap();

        $queue->addToPending('link-1');
        $queue->addToPending('link-2');
        $queue->addToPending('link-3');

        $this->assertTrue($queue->alreadyPending('link-1'));
        $this->assertTrue($queue->alreadyPending('link-2'));
        $this->assertTrue($queue->alreadyPending('link-3'));

        $this->assertFalse($queue->alreadyPending('link-4'));
    }

    /** @test */
    public function can_check_url_has_already_been_crawled(): void
    {
        $queue = new CrawlQueueMap();

        $queue->addToCrawled('link-1');
        $queue->addToCrawled('link-2');
        $queue->addToCrawled('link-3');

        $this->assertTrue($queue->alreadyCrawled('link-1'));
        $this->assertTrue($queue->alreadyCrawled('link-2'));
        $this->assertTrue($queue->alreadyCrawled('link-3'));

        $this->assertFalse($queue->alreadyCrawled('link-4'));
    }

    /** @test */
    public function next_returns_first_item_on_pending_map(): void
    {
        $queue = new CrawlQueueMap();

        $queue->addToPending('link-1');
        $queue->addToPending('link-2');

        $next = $queue->next();

        $this->assertEquals('link-1', $next->key);

        $queue->removeFromPending('link-1');

        $next = $queue->next();

        $this->assertEquals('link-2', $next->key);
    }

}
