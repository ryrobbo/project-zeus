<?php

namespace Zeus\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zeus\Browser\CommunicatesWithBrowser;
use Zeus\Crawlers\CrawlsUrls;
use Zeus\Parsers\Website;

class CrawlWebsiteCommand extends Command
{
    private CrawlsUrls $crawler;

    private CommunicatesWithBrowser $browser;

    protected static $defaultName = 'zeus:crawl';

    public function __construct(CrawlsUrls $crawler, CommunicatesWithBrowser $browser)
    {
        parent::__construct();

        $this->crawler = $crawler;
        $this->browser = $browser;
    }

    protected function configure(): void
    {
        $this->setDescription('Crawls a website')
            ->addArgument('protocol', InputArgument::REQUIRED, 'http or https')
            ->addArgument('domain', InputArgument::REQUIRED, 'Domain of website');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $protocol = $input->getArgument('protocol');
        $domain = $input->getArgument('domain');

        if (is_string($protocol) && is_string($domain)) {
            $website = new Website($protocol, $domain);

            $this->browser->healthCheck($website->getDomainUrl());

            $crawler = $this->crawler->crawl($website);

            return Command::SUCCESS;
        }

        return Command::FAILURE;
    }
}
