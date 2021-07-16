<?php

namespace Zeus\Crawlers;

use Zeus\Parsers\DescribesWebsite;

interface CrawlsUrls
{
    public function crawl(DescribesWebsite $website, ?callable $crawledUrlCallback): CrawlQueue;
}
