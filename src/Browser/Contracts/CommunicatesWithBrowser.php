<?php

namespace Zeus\Browser\Contracts;

interface CommunicatesWithBrowser
{
    public function content(string $url): string;

    public function screenshot(string $url);
}
