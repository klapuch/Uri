<?php
declare(strict_types = 1);
namespace Klapuch\Uri;

/**
 * Cached URI
 */
final class CachedUri implements Uri {
	private $origin;
	private $reference;
	private $path;

	public function __construct(Uri $origin) {
		$this->origin = $origin;
	}

	public function reference(): string {
		if ($this->reference === null)
			$this->reference = $this->origin->reference();
		return $this->reference;
	}

	public function path(): string {
		if ($this->path === null)
			$this->path = $this->origin->path();
		return $this->path;
	}
}