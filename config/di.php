<?php

use Zeus\Browser\Browserless;
use Psr\Container\ContainerInterface;
use Zeus\Parsers\ParseInternalLinks;
use Zeus\Crawlers\CrawlQueueMap;
use Zeus\Crawlers\StandardCrawler;
use Zeus\Parsers\Elements\Anchors\InternalAnchors;
use Zeus\Parsers\Elements\Anchors\HasSamePageAnchorValidator;
use Zeus\Parsers\Elements\Anchors\IsAnchorToMediaResourceValidator;

return [
    Browserless::class => DI\factory(function (ContainerInterface $container) {
        return new Browserless(
            new \Zeus\Browser\Clients\RestfulClient(
                $_ENV['BROWSERLESS_HOST'],
                $_ENV['BROWSERLESS_PORT'],
                $_ENV['BROWSERLESS_TOKEN']
            )
        );
    }),
    InternalAnchors::class => DI\factory(function (ContainerInterface $container) {
        return new InternalAnchors([
            new HasSamePageAnchorValidator(),
            new IsAnchorToMediaResourceValidator()
        ]);
    }),
    ParseInternalLinks::class => DI\factory(function (ContainerInterface $container) {
        return new ParseInternalLinks($container->get(InternalAnchors::class));
    }),
    StandardCrawler::class => DI\factory(function (ContainerInterface $container) {
        return new StandardCrawler(
            $container->get(Browserless::class),
            $container->get(ParseInternalLinks::class),
            new CrawlQueueMap()
        );
    }),
];
