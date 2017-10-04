<?php
declare(strict_types = 1);
namespace Klapuch\Uri;

/**
 * Valid URL is based on the given schemes
 */
final class SchemeForcedUrl implements Uri {
	private $origin;
	private $schemes;

	public function __construct(Uri $origin, array $schemes) {
		$this->origin = $origin;
		$this->schemes = $schemes;
	}

	public function reference(): string {
		$scheme = parse_url($this->origin->reference(), PHP_URL_SCHEME);
		if (in_array(strtolower((string) $scheme), $this->schemes))
			return $this->origin->reference();
		throw new \InvalidArgumentException(
			sprintf(
				'Scheme of the URL must be one of %s',
				$this->toReadableSchemes($this->schemes)
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
	 * Schemes transferred to human readable form
	 * @param array $schemes
	 * @return string
	 */
	private function toReadableSchemes(array $schemes): string {
		$emptyPhrase = ' or left empty';
		$phrase = implode(', ', array_filter($schemes));
		if ($schemes === array_filter($schemes))
			return $phrase;
		return $phrase . $emptyPhrase;
	}
}
