<?php
declare(strict_types = 1);
namespace Klapuch\Uri;

/**
 * URL with included specified scheme
 */
final class SchemeFoistedUrl implements Uri {
	private $origin;
	private $scheme;

	public function __construct(Uri $origin, string $scheme) {
		$this->origin = $origin;
		$this->scheme = $scheme;
	}

	public function reference(): string {
		$scheme = parse_url($this->origin->reference(), PHP_URL_SCHEME);
		if ($scheme)
			return $this->origin->reference();
		return sprintf('%s://%s', $this->scheme, $this->origin->reference());
	}

	public function path(): string {
		return $this->origin->path();
	}

	public function query(): array {
		return $this->origin->query();
	}
}
