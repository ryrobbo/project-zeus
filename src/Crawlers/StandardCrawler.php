<?php declare(strict_types=1);

namespace Zeus\Crawlers;

use Zeus\Browser\UnableToParseUrlException;
use Zeus\Parsers\DescribesWebsite;
use Zeus\Parsers\ParsesHtmlLinks;
use Zeus\Browser\CommunicatesWithBrowser;

class StandardCrawler implements CrawlsUrls
{
    private CommunicatesWithBrowser $browser;

    private ParsesHtmlLinks $linkParser;

    private CrawlQueue $queue;

    public function __construct(
        CommunicatesWithBrowser $browser,
        ParsesHtmlLinks $linkParser,
        CrawlQueue $queue
    )
    {
        $this->browser = $browser;
        $this->linkParser = $linkParser;
        $this->queue = $queue;
    }

    public function crawl(DescribesWebsite $website): CrawlQueue
    {
        $this->queue->addToPending($website->getStartUrl());

        while ($mappedUrl = $this->queue->nextUrl()) {
            if ($this->queue->alreadyCrawled($mappedUrl)) {
                continue;
            }

            try {
                $content = $this->browser->content($this->buildUrl($website, $mappedUrl));

                $urls = $this->linkParser->parse($website, $content);

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

    private function buildUrl(DescribesWebsite $website, string $path): string
    {
        return sprintf(
            '%s%s',
            $website->getDomainUrl(),
            $path
        );
    }
}
