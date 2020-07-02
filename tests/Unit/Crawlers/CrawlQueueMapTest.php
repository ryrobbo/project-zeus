<?php

namespace Tests\Unit\Crawlers;

use PHPUnit\Framework\TestCase;
use Zeus\Crawlers\CrawlQueueMap;

class CrawlQueueMapTest extends TestCase
{
    public function testCanAddUrlToPending(): void
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

    public function testCanAddUrlToCrawled(): void
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

    public function testCanRemoveUrlFromPending(): void
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

    public function testCanCheckUrlIsAlreadyPending(): void
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

    public function testCanCheckUrlHasAlreadyBeenCrawled(): void
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

    public function testNextReturnsFirstItemOnPendingMap(): void
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
