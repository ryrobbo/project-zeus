<?php

namespace Zeus\Crawlers;

use Ds\Map;
use Ds\Pair;
use Zeus\Crawlers\Contracts\CrawlQueue;

class CrawlQueueMap implements CrawlQueue
{
    private Map $pending;

    private Map $crawled;

    public function __construct()
    {
        $this->pending = new Map();
        $this->crawled = new Map();
    }

    public function next(): ?Pair
    {
        foreach ($this->pending as $pendingUrl) {
            return $pendingUrl;
        }

        return null;
    }

    public function addToPending(string $url): void
    {
        $this->pending->put($url, $url);
    }

    public function addToCrawled(string $url): void
    {
        $this->crawled->put($url, $url);
    }

    public function removeFromPending(string $url): void
    {
        $this->pending->remove($url);
    }

    public function alreadyCrawled(string $key): bool
    {
        return $this->crawled->hasKey($key);
    }

    public function alreadyPending(string $key): bool
    {
        return $this->pending->hasKey($key);
    }

    public function getCrawledUrls(): Map
    {
        return $this->crawled;
    }

    public function getPendingUrls(): Map
    {
        return $this->pending;
    }
}
