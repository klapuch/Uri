<?php
declare(strict_types = 1);
namespace Klapuch\Uri;

/*
 * TODO
 * Normalized URL by RFC 3986
 */
final class NormalizedUrl implements Uri {
    private $url;

    public function __construct(string $url) {
        $this->url = $url;
    }

    public function reference(): string {
        $parsedUrl = parse_url(strtolower(trim($this->url, '/')));
        $scheme = isset($parsedUrl['scheme']) ? $parsedUrl['scheme'] . '://' : '';
        $host = $parsedUrl['host'] ?? '';
        $path = $parsedUrl['path'] ?? '';
        $query = isset($parsedUrl['query']) ? '?' . $parsedUrl['query'] : '';
        return $scheme . $host . $path . $query;
    }
}
