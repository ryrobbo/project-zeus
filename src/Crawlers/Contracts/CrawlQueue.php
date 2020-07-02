<?php

namespace Zeus\Crawlers\Contracts;

interface CrawlQueue
{
    public function next();

    public function addToPending(string $url): void;

    public function addToCrawled(string $url): void;

    public function removeFromPending(string $url): void;

    public function alreadyPending(string $key): bool;

    public function alreadyCrawled(string $key): bool;

    public function getPendingUrls();

    public function getCrawledUrls();
}