<?php

namespace Zeus\Parsers;

use Zeus\Parsers\Contracts\DescribesWebsite;

class WebsiteManifest implements DescribesWebsite
{
    private $domain;

    private $protocol;

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
}
