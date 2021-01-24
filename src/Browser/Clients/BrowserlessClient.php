<?php

namespace Zeus\Browser\Clients;

interface BrowserlessClient
{
    public function post(string $uri, array $options): string;
}
