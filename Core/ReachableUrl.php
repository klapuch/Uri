<?php
declare(strict_types = 1);
namespace Klapuch\Uri;

/**
 * URL which is always reachable
 */
final class ReachableUrl implements Uri {
	private const STATUS = 0;
	private const NOT_FOUND = 404;
	private $origin;

	public function __construct(Uri $origin) {
		$this->origin = $origin;
	}

	public function reference(): string {
		if ($this->reachable())
			return $this->origin->reference();
		throw new \InvalidArgumentException(
			sprintf(
				'The given URL "%s" does not exist',
				$this->origin->reference()
			)
		);
	}

	public function path(): string {
		return $this->origin->path();
	}

	public function query(): array {
		return $this->origin->query();
	}

	/**
	 * Is the URL reachable?
	 * @return bool
	 */
	private function reachable(): bool {
		$headers = @get_headers($this->origin->reference());
		return $headers
		&& strpos($headers[self::STATUS], self::NOT_FOUND) === false;
	}
}
