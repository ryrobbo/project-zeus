<?php declare(strict_types=1);

namespace Zeus\Browser\Clients;

use GuzzleHttp\Client;
use Zeus\Browser\Contracts\BrowserlessClient;

class RestfulClient implements BrowserlessClient
{
    private Client $client;

    public function __construct()
    {
        // TODO: construct a Guzzle client.
    }

    public function content(string $url): string
    {
        // TODO: Implement content() method.
        return '';
    }
}