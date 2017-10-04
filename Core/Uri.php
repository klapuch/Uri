<?php
declare(strict_types = 1);
namespace Klapuch\Uri;

interface Uri {
	/**
	 * Path in the URI
	 * @throws \InvalidArgumentException
	 * @return string
	 */
	public function path(): string;

	/**
	 * Address or name of the resource pointed by the URI
	 * @throws \InvalidArgumentException
	 * @return string
	 */
	public function reference(): string;

	/**
	 * Query parameters from URI
	 * @throws \InvalidArgumentException
	 * @return array
	 */
	public function query(): array;
}
