<?php declare(strict_types=1);

namespace Zeus\Browser;

use Zeus\Browser\Clients\BrowserlessClient;

/**
 * Uses a Browserless client to make the necessary calls to the Browserless service.
 * One client could use a HTTP connection using Guzzle or another client could use a Websocket connection.
 *
 * @package Zeus\Browser
 */
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
