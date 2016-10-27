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

final class SchemeFoistedUrl extends Tester\TestCase {
	public function testAlreadyIncludedValidSchemeWithoutFoist() {
		Assert::same(
			'https://www.google.com',
			(new Uri\SchemeFoistedUrl(
				new Uri\FakeUri('https://www.google.com'),
				'https'
			))->reference()
		);
	}

	public function testAlreadyIncludedInvalidSchemeWithoutFoist() {
		Assert::same(
			'foo://www.google.com',
			(new Uri\SchemeFoistedUrl(
				new Uri\FakeUri('foo://www.google.com'),
				'http'
			))->reference()
		);
	}

	public function testDifferentSchemeFromFoisted() {
		Assert::same(
			'https://www.google.com',
			(new Uri\SchemeFoistedUrl(
				new Uri\FakeUri('https://www.google.com'),
				'http'
			))->reference()
		);
	}

	public function testFoistingUnknownScheme() {
		Assert::same(
			'foo://www.google.com',
			(new Uri\SchemeFoistedUrl(
				new Uri\FakeUri('www.google.com'),
				'foo'
			))->reference()
		);
	}

	public function testFoistingValidScheme() {
		Assert::same(
			'https://www.google.com',
			(new Uri\SchemeFoistedUrl(
				new Uri\FakeUri('https://www.google.com'),
				'https'
			))->reference()
		);
	}
}

(new SchemeFoistedUrl())->run();
