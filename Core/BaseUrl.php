<?php
declare(strict_types = 1);
namespace Klapuch\Uri;

/**
 * Base URL considered as a root URL for project
 */
final class BaseUrl implements Uri {
	const DELIMITER = '/';
	const EMPTY = '';
	private $script;
	private $url;
	private $host;
	private $scheme;

	public function __construct(
		string $script,
		string $url,
		string $host = self::EMPTY,
		string $scheme = self::EMPTY
	) {
		$this->script = $script;
		$this->url = $url;
		$this->host = $host;
		$this->scheme = $scheme;
	}

	public function reference(): string {
		return $this->toFullyQualified(
			implode(
				self::DELIMITER,
				$this->withoutExecutedScript(
					explode(self::DELIMITER, $this->script)
				)
			) . self::DELIMITER
		);
	}

	public function path(): string {
		$scriptParts = $this->toParts($this->script);
		$urlParts = $this->toParts(parse_url($this->url, PHP_URL_PATH));
		for($i = 0; $i < count($scriptParts); $i++) {
			if($scriptParts[$i] !== $urlParts[$i]) {
				return implode(
					self::DELIMITER,
					$this->withoutTrailingSlashes(array_slice($urlParts, $i))
				);
			}
		}
		return self::EMPTY;
	}

	/**
	 * Parts of the url without index.php or other file where is script executed
	 * @param array $parts
	 * @return array
	 */
	private function withoutExecutedScript(array $parts): array {
		array_pop($parts);
		return $parts;
	}

	/**
	 * Split the URL to parts
	 * @param string $url
	 * @return array
	 */
	private function toParts(string $url): array {
		return explode(self::DELIMITER, mb_strtolower($url));
	}

	/**
	 * All the parts without trailing slashes i.e. empty parts
	 * @param array $parts
	 * @return array
	 */
	private function withoutTrailingSlashes(array $parts): array {
		return array_filter($parts, 'strlen');
	}

	private function toFullyQualified(string $base): string {
		$scheme = $this->scheme && $this->host
			? preg_replace('~[^a-z]~i', '', $this->scheme) . '://'
			: self::EMPTY;
		return $scheme . $this->host . $base;
	}
}