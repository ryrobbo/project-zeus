<?php declare(strict_types=1);

namespace Zeus\Crawlers;

use Zeus\Browser\UnableToParseUrlException;
use Zeus\Parsers\DescribesWebsite;
use Zeus\Parsers\ParsesHtmlLinks;
use Zeus\Browser\CommunicatesWithBrowser;

class StandardCrawler implements CrawlsUrls
{
    private DescribesWebsite $website;

    private CommunicatesWithBrowser $browser;

    private ParsesHtmlLinks $linkParser;

    private CrawlQueue $queue;

    public function __construct(
        DescribesWebsite $website,
        CommunicatesWithBrowser $browser,
        ParsesHtmlLinks $linkParser,
        CrawlQueue $queue
    )
    {
        $this->website = $website;
        $this->browser = $browser;
        $this->linkParser = $linkParser;
        $this->queue = $queue;
    }

    public function crawl(): CrawlQueue
    {
        $this->queue->addToPending($this->website->getStartUrl());

        while ($mappedUrl = $this->queue->nextUrl()) {
            if ($this->queue->alreadyCrawled($mappedUrl)) {
                continue;
            }

            try {
                $content = $this->browser->content($this->buildUrl($mappedUrl));

                $urls = $this->linkParser->parse($this->website, $content);

                $this->addToPending($urls);

                $this->queue->addToCrawled($mappedUrl);
            } catch (UnableToParseUrlException $e) {
                $this->queue->addToErrored($mappedUrl);
            }

            $this->queue->removeFromPending($mappedUrl);
        }

        return $this->queue;
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

    private function buildUrl(string $path): string
    {
        return sprintf(
            '%s://%s%s',
            $this->website->getProtocol(),
            $this->website->getDomain(),
            $path
        );
    }
}
