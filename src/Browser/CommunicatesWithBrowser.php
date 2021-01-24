<?php

namespace Zeus\Browser;

interface CommunicatesWithBrowser
{
    public function content(string $url): string;

    public function healthCheck(string $url): void;
}
