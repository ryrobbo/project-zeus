<?php declare(strict_types=1);

namespace Zeus\Crawlers;

use Ds\Map;
use Zeus\Crawlers\Contracts\CrawlQueue;

class CrawlQueueMap implements CrawlQueue
{
    /**
     * @var Map<string, string>
     */
    private Map $pending;

    /**
     * @var Map<string, string>
     */
    private Map $crawled;

    public function __construct()
    {
        $this->pending = new Map();
        $this->crawled = new Map();
    }

    public function nextUrl(): ?string
    {
        foreach ($this->pending->pairs() as $pendingUrl) {
            return $pendingUrl->value;
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

    public function getCrawledUrls(): array
    {
        return $this->crawled->toArray();
    }

    public function getPendingUrls(): array
    {
        return $this->pending->toArray();
    }
}
