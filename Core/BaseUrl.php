<?php
declare(strict_types = 1);
namespace Klapuch\Uri;

/**
 * Base URL considered as a root URL for project
 */
final class BaseUrl implements Uri {
	const DELIMITER = '/';
	private $script;
	private $url;

	public function __construct(string $script, string $url) {
		$this->script = $script;
		$this->url = $url;
	}

	public function reference(): string {
		return implode(
			self::DELIMITER,
			$this->withoutExecutedScript(
				explode(self::DELIMITER, $this->script)
			)
		) . self::DELIMITER;
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

	public function path(): string {
		$scriptParts = $this->toParts($this->script);
		$urlParts = $this->toParts($this->url);
		for($i = 0; $i < count($scriptParts); $i++) {
			if($scriptParts[$i] !== $urlParts[$i]) {
				return implode(
					'/',
					$this->withoutQueries(
						$this->withoutTrailingSlashes(
							array_slice($urlParts, $i)
						)
					)
				);
			}
		}
		return '';
	}

	/**
	 * Split the URL to parts
	 * @param string $url
	 * @return array
	 */
	private function toParts(string $url): array {
		return explode('/', mb_strtolower($url));
	}

	/**
	 * All the parts without queries
	 * @param array $parts
	 * @return array
	 */
	private function withoutQueries(array $parts): array {
		return array_filter(
			$parts,
			function(string $part): bool {
				return !preg_match('~[\?]{1}[\S\s]*=[\S\s]*~', $part);
			}
		);
	}

	/**
	 * All the parts without trailing slashes i.e. empty parts
	 * @param array $parts
	 * @return array
	 */
	private function withoutTrailingSlashes(array $parts): array {
		return array_filter($parts, 'strlen');
	}
}