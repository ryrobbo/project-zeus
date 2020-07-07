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

        $pending = array_values($queue->getPendingUrls());

        $this->assertCount(3, $pending);

        $this->assertEquals('link-1', $pending[0]);
        $this->assertEquals('link-3', $pending[2]);
    }

    public function testCanAddUrlToCrawled(): void
    {
        $queue = new CrawlQueueMap();

        $queue->addToCrawled('link-1');
        $queue->addToCrawled('link-2');
        $queue->addToCrawled('link-3');

        $crawled = array_values($queue->getCrawledUrls());

        $this->assertCount(3, $crawled);

        $this->assertEquals('link-1', $crawled[0]);
        $this->assertEquals('link-3', $crawled[2]);
    }

    public function testCanRemoveUrlFromPending(): void
    {
        $queue = new CrawlQueueMap();

        $queue->addToPending('link-1');
        $queue->addToPending('link-2');
        $queue->addToPending('link-3');

        $pending = array_values($queue->getPendingUrls());

        $this->assertCount(3, $pending);

        $queue->removeFromPending('link-1');
        $queue->removeFromPending('link-2');

        $pending = array_values($queue->getPendingUrls());

        $this->assertCount(1, $pending);

        $this->assertEquals('link-3', $pending[0]);
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

        $next = $queue->nextUrl();

        $this->assertEquals('link-1', $next);

        $queue->removeFromPending('link-1');

        $next = $queue->nextUrl();

        $this->assertEquals('link-2', $next);
    }

}
