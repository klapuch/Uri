<?php
declare(strict_types = 1);
namespace Klapuch\Uri;

/**
 * URL extracted domain with a proper scheme
 */
final class Domain implements Uri {
	private $origin;

	public function __construct(Uri $origin) {
		$this->origin = $origin;
	}

	public function path(): string {
		return $this->origin->path();
	}

	public function reference(): string {
		$url = $this->origin->reference();
		$scheme = parse_url($url, PHP_URL_SCHEME);
		$host = parse_url($url, PHP_URL_HOST);
		return $scheme . '://' . $host;
	}

	public function query(): array {
		return $this->origin->query();
	}
}
