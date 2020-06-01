<?php

namespace Zeus\Parsers;

use Zeus\Parsers\Contracts\DescribesWebsite;

class WebsiteManifest implements DescribesWebsite
{
    private string $domain;

    private string $protocol;

    private string $startUrl = '/';

    public function __construct(string $domain, string $protocol)
    {
        $this->domain = $domain;
        $this->protocol = $protocol;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function getProtocol(): string
    {
        return $this->protocol;
    }

    public function getStartUrl(): string
    {
        return $this->startUrl;
    }

    public function setStartUrl(string $url): DescribesWebsite
    {
        $this->startUrl = $url;
        return $this;
    }
}