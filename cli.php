#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;

/** @var \Zeus\Zeus $zeusApp */
$zeusApp = require_once __DIR__ . '/bootstrap/zeus.php';

$application = new Application('zeus', '1.0.0');

$application->add(
    new \Zeus\Commands\CrawlWebsiteCommand($zeusApp->container()->get(\Zeus\Crawlers\StandardCrawler::class))
);

$application->run();
