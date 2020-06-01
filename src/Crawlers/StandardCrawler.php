<?php

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
        ParsesHtmlDocuments $parser
    )
    {
        $this->website = $website;
        $this->browser = $browser;
        $this->parser = $parser;
        $this->queue = new CrawlQueueMap(); // TODO: DI
    }

    public function crawl()
    {
        $this->queue->add($this->website->getStartUrl());

        while ($mappedUrl = $this->queue->next()) {
            if ($this->queue->alreadyCrawled($mappedUrl->key)) {
                continue;
            }

            $content = $this->browser->content($mappedUrl->value);

            $this->parser->loadHtml($content);
            $urls = $this->parser->getLinks();

            $this->addToPending($urls);

            // remove self from pending
            $this->queue->remove($mappedUrl->key);
        }
    }

    private function addToPending(array $urls): void
    {
        $urls = array_filter($urls, function (string $url) {
            return (! $this->queue->alreadyCrawled($url) && ! $this->queue->alreadyPending($url));
        });

        foreach ($urls as $url) {
            $this->queue->add($url);
        }
    }
}
