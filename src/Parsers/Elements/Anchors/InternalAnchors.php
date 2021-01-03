<?php declare(strict_types=1);

namespace Zeus\Parsers\Elements\Anchors;

class InternalAnchors implements ParsesAnchors
{
    /** @var ValidatesInternalAnchor[] */
    private $validators;

    public function __construct(array $validators)
    {
        $this->validators = $validators;
    }

    public function parseAnchors(string $domain, \DOMDocument $document): array
    {
        $documentLinks = $document->getElementsByTagName('a');

        $internalLinks = $this->extractInternalAnchors($domain, $documentLinks);

        $internalLinks = $this->onlyUniqueLinks($internalLinks);

        $internalLinks = $this->trimLinks($internalLinks);

        $internalLinks = $this->filterInvalidLinks($internalLinks);

        return $internalLinks;
    }

    private function extractInternalAnchors(string $domain, \DOMNodeList $documentLinks): array
    {
        $internalLinks = [];

        foreach ($documentLinks as $link) {
            /** @var \DOMElement $link */
            $href = $link->getAttribute('href');

            /** Absolute URLs could be internal or external links */
            if ($this->isAnchorAbsolute($href)) {
                $parsedUrl = parse_url($href);

                if (isset($parsedUrl['host']) && isset($parsedUrl['path'])) {
                    if ($this->isParsedUrlInternal($parsedUrl, $domain)) {
                        array_push($internalLinks, $parsedUrl['path']);
                    }
                }
            } else {
                array_push($internalLinks, $href);
            }
        }

        return $internalLinks;
    }

    private function isAnchorAbsolute(string $href): bool
    {
        return substr($href, 0, 4) === 'http';
    }

    private function isParsedUrlInternal(array $parsedUrl, string $domain): bool
    {
        return $parsedUrl['host'] === $domain || $parsedUrl['host'] === 'www.' . $domain;
    }

    private function onlyUniqueLinks(array $links): array
    {
        return array_values(array_unique($links));
    }

    private function trimLinks(array $links): array
    {
        return array_map(
            fn (string $link) => (strlen($link) > 1) ? rtrim($link, '/') : $link,
            $links
        );
    }

    private function filterInvalidLinks(array $links): array
    {
        foreach ($this->validators as $validator) {
            $links = array_filter(
                $links,
                fn (string $link) => ! $validator->validate($link)
            );
        }

        return $links;
    }
}
