<?php
declare(strict_types = 1);
/**
 * @testCase
 * @phpVersion > 7.0.0
 */
namespace Klapuch\Uri\Unit;

use Klapuch\Uri;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class SchemeForcedUrl extends Tester\TestCase {
	/**
	 * @dataProvider schemeBasedUrls
	 */
	public function testSchemeBasedUrlWithoutFail($url) {
		Assert::same(
			$url,
			(new Uri\SchemeForcedUrl(
				new Uri\FakeUri($url),
				['http', 'https', '']
			))->reference()
		);
	}

	/**
	 * @dataProvider nonSchemeBasedUrls
	 */
	public function testNonSchemeBasedUrlsWithFail($url) {
		Assert::exception(
			function() use ($url) {
				(new Uri\SchemeForcedUrl(
					new Uri\FakeUri($url),
					['http', 'https']
				))->reference();
			},
			\InvalidArgumentException::class,
			'Scheme of the URL must be one of http, https'
		);
		Assert::exception(
			function() use ($url) {
				(new Uri\SchemeForcedUrl(
					new Uri\FakeUri($url),
					['http', 'https', '']
				))->reference();
			},
			\InvalidArgumentException::class,
			'Scheme of the URL must be one of http, https or left empty'
		);
	}

	protected function schemeBasedUrls() {
		return [
			['http://www.google.com'],
			['https://www.google.com'],
			['httpS://Www.Google.Com'],
			['https://google.com'],
			['www.google.com/'],
			['google.com/'],
			['http://www.google.com:80'],
			['http://www.google.com:8080'],
			['http://www.google.com:foo'],
			[''],
			['/'],
			['localhost'],
			['http://localhost'],
			['127.0.0.1'],
			['124.12.34.22'],
			['127.0.0.1:80'],
			['http://127.0.0.1:80'],
		];
	}

	protected function nonSchemeBasedUrls() {
		return [
			['ftp://server.com'],
			['ftp://localhost'],
			['ftp://127.0.0.1'],
			['httpr://server.com'],
		];
	}
}

(new SchemeForcedUrl())->run();
