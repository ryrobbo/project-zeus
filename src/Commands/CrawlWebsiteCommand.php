<?php

namespace Zeus\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zeus\Crawlers\CrawlsUrls;
use Zeus\Parsers\Website;

class CrawlWebsiteCommand extends Command
{
    private CrawlsUrls $crawler;

    protected static $defaultName = 'zeus:crawl';

    public function __construct(CrawlsUrls $crawler)
    {
        parent::__construct();

        $this->crawler = $crawler;
    }

    protected function configure(): void
    {
        $this->setDescription('Crawls a website');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->crawler->crawl(new Website('ryrobbo.com', 'http'));

        return Command::SUCCESS;
    }
}
