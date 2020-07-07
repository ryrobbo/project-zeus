<?php declare(strict_types=1);

namespace Zeus\Crawlers;

use Zeus\Crawlers\Contracts\CrawlQueue;
use Zeus\Crawlers\Contracts\CrawlsUrls;
use Zeus\Parsers\Contracts\DescribesWebsite;
use Zeus\Parsers\Contracts\ParsesHtmlDocuments;
use Zeus\Browser\Contracts\CommunicatesWithBrowser;

class StandardCrawler implements CrawlsUrls
{
    private DescribesWebsite $website;

    private CommunicatesWithBrowser $browser;

    private ParsesHtmlDocuments $parser;

    private CrawlQueue $queue;

    public function __construct(
        DescribesWebsite $website,
        CommunicatesWithBrowser $browser,
        ParsesHtmlDocuments $parser,
        CrawlQueue $queue
    )
    {
        $this->website = $website;
        $this->browser = $browser;
        $this->parser = $parser;
        $this->queue = $queue;
    }

    public function crawl(): array
    {
        $this->queue->addToPending($this->website->getStartUrl());

        while ($mappedUrl = $this->queue->nextUrl()) {
            if ($this->queue->alreadyCrawled($mappedUrl)) {
                continue;
            }

            $content = $this->browser->content($mappedUrl);

            $this->parser->loadHtml($content);
            $urls = $this->parser->getLinks();

            $this->addToPending($urls);

            $this->queue->addToCrawled($mappedUrl);

            $this->queue->removeFromPending($mappedUrl);
        }

        return $this->queue->getCrawledUrls();
    }

    private function addToPending(array $urls): void
    {
        $urls = array_filter($urls, function (string $url) {
            return (! $this->queue->alreadyCrawled($url) && ! $this->queue->alreadyPending($url));
        });

        foreach ($urls as $url) {
            $this->queue->addToPending($url);
        }
    }
}
