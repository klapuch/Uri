<?php
declare(strict_types = 1);
namespace Klapuch\Uri;

/**
 * Fake URI
 */
final class FakeUri implements Uri {
	private $uri;
	private $path;

	public function __construct(string $uri = null, string $path = null) {
		$this->uri = $uri;
		$this->path = $path;
	}

	public function reference(): string {
		return $this->uri;
	}

	public function path(): string {
		return $this->path;
	}
}
