<?php
/**
 * @testCase
 * @phpVersion > 7.0.0
 */
namespace Klapuch\Uri\Integration;

use Klapuch\Uri;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class ReachableUrl extends Tester\TestCase {
	/**
	 * @dataProvider existingUrls
	 */
	public function testExistingUrls($url) {
		Assert::same(
			$url,
			(new Uri\ReachableUrl(new Uri\FakeUri($url)))->reference()
		);
	}

	/**
	 * @dataProvider unknownUrls
	 */
	public function testUnknownUrls($url) {
		Assert::exception(
			function() use ($url) {
				(new Uri\ReachableUrl(new Uri\FakeUri($url)))->reference();
			},
			\InvalidArgumentException::class,
			"The given URL \"$url\" does not exist"
		);
	}

	protected function existingUrls() {
		return [
			['http://www.example.com'], // http
			['https://www.google.com'], // https
			['https://www.nette.org'], // redirect with 301
		];
	}

	protected function unknownUrls() {
		return [
			['http://www.foobar.foobar'],
			['ftp://ftp.mirror.nl/'],
		];
	}
}

(new ReachableUrl())->run();
