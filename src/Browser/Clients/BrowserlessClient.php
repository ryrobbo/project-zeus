<?php

namespace Zeus\Browser\Clients;

interface BrowserlessClient
{
    public function content(string $url): string;
}
