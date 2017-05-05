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

final class NormalizedUrl extends Tester\TestCase {
	/**
	 * @dataProvider urls
	 */
	public function testNormalization($actual, $expected) {
		Assert::same(
			$expected,
			(new Uri\NormalizedUrl(new Uri\FakeUri($actual)))->reference()
		);
	}

	protected function urls() {
		// [actual, expected]
		return [
			['https://www.google.com', 'https://www.google.com'],
			['httpS://Www.Google.Com', 'https://www.google.com'],
			['https://www.google.com/', 'https://www.google.com'],
			['www.google.com/', 'www.google.com'],
			['google.com/', 'google.com'],
			['google.com/p/a/t/h', 'google.com/p/a/t/h'],
			['google.com/p/a/t/h/', 'google.com/p/a/t/h'],
			['www.google.com?query=value', 'www.google.com?query=value'],
			['www.google.com?query=', 'www.google.com?query='],
			['www.google.com#hashTag', 'www.google.com'],
			['', ''],
			['foo', 'foo'],
			['123', '123'],
			['https://www.google.com:80', 'https://www.google.com'],
			['https://www.google.com:foo', ''],
			['???', '???'],
		];
	}
}

(new NormalizedUrl())->run();
