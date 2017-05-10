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

final class RelativeUrl extends Tester\TestCase {
	public function testOriginReference() {
		Assert::same('abc', (new Uri\RelativeUrl(new Uri\FakeUri('abc'), ''))->reference());
		Assert::same(' foo ', (new Uri\RelativeUrl(new Uri\FakeUri(' foo '), ''))->reference());
	}

	public function testPassedPathWithoutDelimiter() {
		Assert::same('foo', (new Uri\RelativeUrl(new Uri\FakeUri(), '/foo/'))->path());
	}
}

(new RelativeUrl())->run();