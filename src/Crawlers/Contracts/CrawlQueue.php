<?php

namespace Zeus\Crawlers\Contracts;

use Ds\Pair;

interface CrawlQueue
{
    public function next(): ?Pair;

    public function add(string $url): void;

    public function remove(string $url): void;

    public function alreadyPending(string $key): bool;

    public function alreadyCrawled(string $key): bool;
}
