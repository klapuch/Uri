<?php
/**
 * @testCase
 * @phpVersion > 7.0.0
 */
namespace Klapuch\Uri\Unit;

use Klapuch\Uri;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class ProtocolBasedUrl extends Tester\TestCase {
	/**
	 * @dataProvider protocolBasedUrls
	 */
	public function testProtocolBasedUrlWithoutFail($url) {
		Assert::same(
			$url,
			(new Uri\ProtocolBasedUrl(
				new Uri\FakeUri($url),
				['http', 'https', '']
			))->reference()
		);
	}

	/**
	 * @dataProvider nonProtocolBasedUrls
	 */
	public function testNonProtocolBasedUrlsWithFail($url) {
		Assert::exception(
			function() use ($url) {
				(new Uri\ProtocolBasedUrl(
					new Uri\FakeUri($url),
					['http', 'https']
				))->reference();
			},
			\InvalidArgumentException::class,
			'Protocol of the URL must be one of http, https'
		);
		Assert::exception(
			function() use ($url) {
				(new Uri\ProtocolBasedUrl(
					new Uri\FakeUri($url),
					['http', 'https', '']
				))->reference();
			},
			\InvalidArgumentException::class,
			'Protocol of the URL must be one of http, https or left empty'
		);
	}

	protected function protocolBasedUrls() {
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

	protected function nonProtocolBasedUrls() {
		return [
			['ftp://server.com'],
			['ftp://localhost'],
			['ftp://127.0.0.1'],
			['httpr://server.com'],
		];
	}
}

(new ProtocolBasedUrl())->run();
