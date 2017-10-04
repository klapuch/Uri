<?php
declare(strict_types = 1);
namespace Klapuch\Uri;

/**
 * TODO
 * Normalized URL by RFC 3986
 */
final class NormalizedUrl implements Uri {
	private $origin;

	public function __construct(Uri $origin) {
		$this->origin = $origin;
	}

	public function reference(): string {
		$parsedUrl = parse_url(
			strtolower(rtrim($this->origin->reference(), '/'))
		);
		$scheme = isset($parsedUrl['scheme']) ? $parsedUrl['scheme'] . '://' : '';
		$host = $parsedUrl['host'] ?? '';
		$path = $parsedUrl['path'] ?? '';
		$query = isset($parsedUrl['query']) ? '?' . $parsedUrl['query'] : '';
		return $scheme . $host . $path . $query;
	}

	public function path(): string {
		return $this->origin->path();
	}

	public function query(): array {
		return $this->origin->query();
	}
}
