<?php

namespace Zeus\Crawlers;

use Zeus\Crawlers\Contracts\CrawlerContract;

class StandardCrawler implements CrawlerContract
{
    private $pending;

    private $crawled;

    public function crawl()
    {
        $protocol = 'http';
        $domain = 'ryrobbo.com';

    }
}
