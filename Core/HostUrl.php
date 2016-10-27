<?php
declare(strict_types = 1);
namespace Klapuch\Uri;

/**
 * URL extracted host
 */
final class HostUrl implements Uri {
	private $origin;

	public function __construct(Uri $origin) {
		$this->origin = $origin;
	}

	public function path(): string {
		return $this->origin->path();
	}

	public function reference(): string {
		return parse_url($this->origin->reference(), PHP_URL_HOST);
	}
}
