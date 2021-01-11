<?php

namespace Zeus\Browser;

interface CommunicatesWithBrowser
{
    public function content(string $url): string;
}
