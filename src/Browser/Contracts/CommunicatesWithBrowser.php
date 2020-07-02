<?php

namespace Zeus\Browser\Contracts;

interface CommunicatesWithBrowser
{
    public function content(string $url): string;
}
