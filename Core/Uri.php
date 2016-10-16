<?php
declare(strict_types = 1);
namespace Klapuch\Uri;

interface Uri {
	/**
	 * Address or name of the resource pointed by the URI
	 * @throws \InvalidArgumentException
	 * @return string
	 */
	public function reference(): string;

	/**
	 * Path in the URI
	 * @throws \InvalidArgumentException
	 * @return string
	 */
	public function path(): string;
}
