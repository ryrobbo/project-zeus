<?php

namespace Zeus\Crawlers;

interface CrawlQueue
{
    public function nextUrl(): ?string;

    public function addToErrored(string $url): void;

    public function addToPending(string $url): void;

    public function addToCrawled(string $url): void;

    public function removeFromPending(string $url): void;

    public function alreadyPending(string $key): bool;

    public function alreadyCrawled(string $key): bool;

    public function getPendingUrls(): array;

    public function getCrawledUrls(): array;

    public function getErroredUrls(): array;
}
