<?php
declare(strict_types = 1);
namespace Klapuch\Uri;

/**
 * Fake URI
 */
final class FakeUri implements Uri {
	private $uri;
	private $path;
	private $query;

	public function __construct(string $uri = null, string $path = null, array $query = null) {
		$this->uri = $uri;
		$this->path = $path;
		$this->query = $query;
	}

	public function reference(): string {
		return $this->uri;
	}

	public function path(): string {
		return $this->path;
	}

	public function query(): array {
		return $this->query;
	}
}
