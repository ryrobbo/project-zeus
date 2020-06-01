<?php

namespace Zeus\Browser\Clients;

use GuzzleHttp\Client;
use Zeus\Browserless\Contracts\BrowserlessClient;

class RestfulClient implements BrowserlessClient
{
    private Client $client;

    public function __construct()
    {
    }
}