<?php

require_once 'vendor/autoload.php';

$website = new \Zeus\Parsers\Website('ryrobbo.com', 'http');
$browser = new \Zeus\Browser\Browserless(new \Zeus\Browser\Clients\RestfulClient());
$parser = new \Zeus\Parsers\CrawledHtmlParser($website, new \Zeus\Parsers\Elements\InternalAnchors());
$queue = new \Zeus\Crawlers\CrawlQueueMap();

$crawler = new \Zeus\Crawlers\StandardCrawler($website, $browser, $parser, $queue);

$crawledUrls = $crawler->crawl();
