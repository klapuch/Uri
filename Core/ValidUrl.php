<?php
declare(strict_types = 1);
namespace Klapuch\Uri;

/**
 * Valid URL
 */
final class ValidUrl implements Uri {
	private $url;

	public function __construct(string $url) {
		$this->url = $url;
	}

	public function path(): string {
		return rtrim((string) parse_url($this->reference(), PHP_URL_PATH), '/');
	}

	public function reference(): string {
		if ($this->valid())
			return $this->url;
		throw new \InvalidArgumentException(
			sprintf('The given URL "%s" is not valid', $this->url)
		);
	}

	public function query(): array {
		parse_str((string) parse_url($this->reference(), PHP_URL_QUERY), $query);
		return $query;
	}

	/**
	 * Is the given url valid?
	 * @return bool
	 */
	private function valid(): bool {
		return (bool) filter_var($this->url, FILTER_VALIDATE_URL);
	}
}
