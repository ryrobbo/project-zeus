<?php declare(strict_types=1);

namespace Zeus\Parsers;

use Assert\Assertion;

class Website implements DescribesWebsite
{
    private string $protocol;

    private string $domain;

    private string $startUrl = '/';

    public function __construct(string $protocol, string $domain)
    {
        Assertion::inArray($protocol, ['http', 'https']);
        $this->protocol = $protocol;

        Assertion::regex($domain, '/^[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9]\.[a-zA-Z]{2,}$/');
        $this->domain = $domain;
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

    public function getDomainUrl(): string
    {
        return sprintf(
            '%s://%s',
            $this->protocol,
            $this->domain
        );
    }

    public function setStartUrl(string $url): DescribesWebsite
    {
        $this->startUrl = $url;
        return $this;
    }
}
