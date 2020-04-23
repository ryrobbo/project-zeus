<?php

namespace Zeus\Parsers\Elements;

use Zeus\Parsers\Contracts\DescribesWebsite;
use Zeus\Parsers\Elements\Contracts\ParseAnchors;

class InternalAnchors implements ParseAnchors
{
    public function parseAnchors(DescribesWebsite $website, \DOMDocument $document): array
    {
        $internalLinks = [];

        $documentLinks = $document->getElementsByTagName('a');

        foreach ($documentLinks as $link) {
            $href = $link->getAttribute('href');

            if (substr($href, 0, 4) === 'http') {
                $url = parse_url($href);
                if ($url['host'] === $website->getDomain() || $url['host'] === 'www.' . $website->getDomain()) {
                    array_push($internalLinks, $url['path']);
                }
            } else {
                array_push($internalLinks, $href);
            }
        }

        $internalLinks = array_values(array_unique($internalLinks));

        $internalLinks = array_map(
            fn (string $link) => (strlen($link) > 1) ? rtrim($link, '/') : $link,
            $internalLinks
        );

        return $internalLinks;
    }
}
