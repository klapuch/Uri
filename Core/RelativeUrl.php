<?php
declare(strict_types = 1);
namespace Klapuch\Uri;

/**
 * Relative URL to the origin one
 */
final class RelativeUrl implements Uri {
	private const DELIMITER = '/';
	private $origin;
	private $path;

	public function __construct(Uri $origin, string $path) {
		$this->origin = $origin;
		$this->path = $path;
	}

	public function reference(): string {
		return $this->origin->reference();
	}

	public function path(): string {
		return trim($this->path, self::DELIMITER);
	}

	public function query(): array {
		return $this->origin->query();
	}
}