<?php

namespace Zeus\Crawlers\Contracts;

use Ds\Map;
use Ds\Pair;

interface CrawlQueue
{
    public function next(): ?Pair;

    public function addToPending(string $url): void;

    public function addToCrawled(string $url): void;

    public function removeFromPending(string $url): void;

    public function alreadyPending(string $key): bool;

    public function alreadyCrawled(string $key): bool;

    public function getPendingUrls();

    public function getCrawledUrls();
}
