<?php declare(strict_types=1);

namespace Zeus\Browser;

use Zeus\Browser\Contracts\BrowserlessClient;
use Zeus\Browser\Contracts\CommunicatesWithBrowser;

class Browserless implements CommunicatesWithBrowser
{
    private BrowserlessClient $client;

    public function __construct(BrowserlessClient $client)
    {
        $this->client = $client;
    }

    public function content(string $url): string
    {
        return $this->client->content($url);
    }
}