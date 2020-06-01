<?php

namespace Zeus\Parsers\Elements;

use Zeus\Parsers\Elements\Contracts\ParsesAnchors;

class InternalAnchors implements ParsesAnchors
{
    public function parseAnchors(string $domain, \DOMDocument $document): array
    {
        $internalLinks = [];

        $documentLinks = $document->getElementsByTagName('a');

        foreach ($documentLinks as $link) {
            $href = $link->getAttribute('href');

            if (substr($href, 0, 4) === 'http') {
                $url = parse_url($href);
                if ($url['host'] === $domain || $url['host'] === 'www.' . $domain) {
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
