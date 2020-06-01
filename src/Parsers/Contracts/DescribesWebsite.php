<?php

namespace Zeus\Parsers\Contracts;

interface DescribesWebsite
{
    public function getDomain(): string;

    public function getProtocol(): string;

    public function getStartUrl(): string;

    public function setStartUrl(string $url): DescribesWebsite;
}
