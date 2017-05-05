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

final class ValidUrl extends Tester\TestCase {
	/**
	 * @dataProvider validReferences
	 */
	public function testValidReference($url) {
		Assert::same($url, (new Uri\ValidUrl($url))->reference());
	}

	/**
	 * @dataProvider invalidReferences
	 */
	public function testInvalidReferenceWithFail($url) {
		Assert::exception(
			function() use ($url) {
				(new Uri\ValidUrl($url))->reference();
			},
			\InvalidArgumentException::class,
			sprintf('The given URL "%s" is not valid', $url)
		);
	}

	/**
	 * @dataProvider paths
	 */
	public function testPaths($url, $path) {
		Assert::same($path, (new Uri\ValidUrl($url))->path());
	}

	public function testInvalidUrlWithoutPath() {
		Assert::exception(
			function() {
				(new Uri\ValidUrl('foo.com/a/b/c'))->path();
			},
			\InvalidArgumentException::class,
			'The given URL "foo.com/a/b/c" is not valid'
		);
	}

	protected function validReferences() {
		return [
			['http://www.google.com'],
			['http://www.google.com/'],
			['http://www.google.com:80'],
			['http://www.google.com:8080'],
			['https://www.google.com'],
			['ftp://www.google.com'],
			['http://192.168.1.12'],
			['http://192.168.1.12/some-page'],
		];
	}

	protected function invalidReferences() {
		return [
			['localhost'],
			['127.0.0.1'],
			['123.45.67.87'],
			['www.google.com'],
			['google.com'],
			['foo'],
		];
	}

	protected function paths() {
		return [
			['http://www.google.com/a/b/c', '/a/b/c'],
			['http://www.google.com/a/b/c?a=ok', '/a/b/c'],
			['http://www.google.com/a/b/c/?a=ok', '/a/b/c'],
			['http://www.google.com', ''],
			['http://www.google.com/', ''],
			['http://www.google.com?a=ok', ''],
		];
	}
}

(new ValidUrl())->run();
