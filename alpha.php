<?php

require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$browser = new \Zeus\Browser\Browserless(
    new \Zeus\Browser\Clients\RestfulClient(
        $_ENV['BROWSERLESS_HOST'],
        $_ENV['BROWSERLESS_PORT'],
        $_ENV['BROWSERLESS_TOKEN']
    )
);

$website = new \Zeus\Parsers\Website('ryrobbo.com', 'http');
$internalAnchors = new \Zeus\Parsers\Elements\Anchors\InternalAnchors([
    new \Zeus\Parsers\Elements\Anchors\HasSamePageAnchorValidator(),
    new \Zeus\Parsers\Elements\Anchors\IsAnchorToMediaResourceValidator()
]);
$parser = new \Zeus\Parsers\CrawledHtmlParser($website, $internalAnchors);
$queue = new \Zeus\Crawlers\CrawlQueueMap();

$crawler = new \Zeus\Crawlers\StandardCrawler($website, $browser, $parser, $queue);

$crawlQueue = $crawler->crawl();

$crawlQueue;
