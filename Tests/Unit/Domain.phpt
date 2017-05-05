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

final class Domain extends Tester\TestCase {
	/**
	 * @dataProvider domains
	 */
	public function testDomains($current, $expected) {
		Assert::same(
			$expected,
			(new Uri\Domain(new Uri\FakeUri($current)))->reference()
		);
	}

	protected function domains() {
		// [current, expected]
		return [
			['http://www.google.com', 'http://www.google.com'],
			['http://www.google.com/', 'http://www.google.com'],
			['https://www.google.com/abc', 'https://www.google.com'],
			['http://www.google.com?a=b', 'http://www.google.com'],
			['http://www.google.com#hash', 'http://www.google.com'],
			['http://google.com', 'http://google.com'],
			['http://mail.google.com', 'http://mail.google.com'],
			['http://www.mail.google.com', 'http://www.mail.google.com'],
			['ftp://secret.server', 'ftp://secret.server'],
		];
	}
}

(new Domain())->run();
