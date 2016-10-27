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

final class HostUrl extends Tester\TestCase {
	protected function hosts() {
		// [current, expected]
		return [
			['http://www.google.com', 'www.google.com'],
			['http://www.google.com/', 'www.google.com'],
			['http://www.google.com/abc', 'www.google.com'],
			['http://www.google.com?a=b', 'www.google.com'],
			['http://www.google.com#hash', 'www.google.com'],
			['http://google.com', 'google.com'],
		];
	}

	/**
	 * @dataProvider hosts
	 */
	public function testHosts($current, $expected) {
		Assert::same(
			$expected,
			(new Uri\HostUrl(new Uri\FakeUri($current)))->reference()
		);
	}
}

(new HostUrl())->run();
