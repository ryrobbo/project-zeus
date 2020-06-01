<?php

namespace Zeus\Browser\Contracts;

interface BrowserlessClient
{
    public function content(string $url): string;

    public function screenshot(string $url);
}
