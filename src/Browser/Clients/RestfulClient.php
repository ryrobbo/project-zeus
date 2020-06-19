<?php

namespace Zeus\Browser\Clients;

use GuzzleHttp\Client;
use Zeus\Browser\Contracts\BrowserlessClient;

class RestfulClient implements BrowserlessClient
{
    private Client $client;

    public function __construct()
    {
    }

    public function content(string $url): string
    {
        // TODO: Implement content() method.
        return '';
    }

    public function screenshot(string $url)
    {
        // TODO: Implement screenshot() method.
    }
}