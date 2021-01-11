<?php

namespace Zeus\Crawlers;

interface CrawlsUrls
{
    public function crawl(): CrawlQueue;
}
