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

final class BaseUrl extends Tester\TestCase {
	/**
	 * @dataProvider paths
	 */
	public function testChoppedPaths($script, $url, $path) {
		Assert::same($path, (new Uri\BaseUrl($script, $url, '', ''))->path());
	}

	/**
	 * @dataProvider urls
	 */
	public function testChoppedUrls($script, $reference) {
		Assert::same(
			$reference,
			(new Uri\BaseUrl($script, 'doesn\'t matter', '', ''))->reference()
		);
	}

	public function testWithHost() {
		Assert::same(
			'localhost/foo',
			(new Uri\BaseUrl(
				'/foo/index.php',
				'doesn\'t matter',
				'localhost',
				''
			))->reference()
		);
	}

	public function testWithoutHost() {
		Assert::same(
			'/foo',
			(new Uri\BaseUrl(
				'/foo/index.php',
				'doesn\'t matter',
				'',
				''
			))->reference()
		);
	}

	public function testWithoutHostButWithScheme() {
		Assert::same(
			'/foo',
			(new Uri\BaseUrl(
				'/foo/index.php',
				'doesn\'t matter',
				'',
				'http'
			))->reference()
		);
	}

	public function testExtractingQuery() {
		Assert::same(
			['name' => 'Dom', 'age' => '21'],
			(new Uri\BaseUrl(
				'/Acme/www/index.php',
				'/Acme/www/a/b/c/?name=Dom&age=21',
				'localhost',
				'https'
			))->query()
		);
	}

	public function testNoQueryLeadingToEmptyArray() {
		Assert::same(
			[],
			(new Uri\BaseUrl(
				'/Acme/www/index.php',
				'/Acme/www/a/b/c',
				'localhost',
				'https'
			))->query()
		);
	}

	public function testWithScheme() {
		Assert::same(
			'http://localhost/foo',
			(new Uri\BaseUrl(
				'/foo/index.php',
				'doesn\'t matter',
				'localhost',
				'http'
			))->reference()
		);
	}

	public function testSchemeWithExtraCharacters() {
		Assert::same(
			'http://localhost/foo',
			(new Uri\BaseUrl(
				'/foo/index.php',
				'doesn\'t matter',
				'localhost',
				'http://'
			))->reference()
		);
	}

	protected function urls() {
		return [
			// [scriptUrl, expected]
			['/foo/www/index.php', '/foo/www'],
			['/foo/index.php', '/foo'],
			['/Foo/index.php', '/Foo'],
			['/foo/categories/bar/www/index.php', '/foo/categories/bar/www'],
			['/foo/www/index.php', '/foo/www'],
			['/foo/www/index.php', '/foo/www'],
			['/foo/index.php', '/foo'],
			['/index.php', ''],
		];
	}

	protected function paths() {
		return [
			['/Acme/www/index.php', '/Acme/www/a/b/c', 'a/b/c'],
			['/Acme/index.php', '/Acme/a/b/c', 'a/b/c'],
			['/Acme/index.php', '/Acme/index.php', ''],
			['/Acme/index.php', '/Acme/index.php/', ''],
			['/Acme/index.php', '/Acme/a/b/c/0', 'a/b/c/0'],
			['/Ac/2/Me/www/index.php', '/Ac/2/Me/www/a/b/c', 'a/b/c'],
			['/index.php', '/a/b/c', 'a/b/c'],
			['/Acme/www/index.php', '/Acme/www/registration', 'registration'],
			['/acme/www/index.php', '/acme/www/page/view', 'page/view'],
			['/acme/www/index.php', '/acme/www/page/view/?get=someValue', 'page/view'],
			['/acme/www/index.php', '/acme/www/page/?get=someValue', 'page'],
			['/acme/www/index.php', '/acme/www/page/view?get=someValue', 'page/view'],
			['/acme/www/index.php', '/acme/www/page/view?xpath=//h1', 'page/view'],
			['/acme/www/index.php', '/acme/www/page/view/?xpath=//h1', 'page/view'],
			['/acme/www/index.php', '/acme/www/page/view?url=http://www.google.com', 'page/view'],
			['/acme/www/index.php', '/acme/www/page/view/?url=http://www.google.com', 'page/view'],
			['/acme/www/index.php', '/acme/www/page/view/1/?get=someValue', 'page/view/1'],
			['index.php', '/page/view/', 'page/view'],
			['/index.php/', '/page/view/', 'page/view'],
			['/index.php/', '/page/view/view/page', 'page/view/view/page'], // there may be duplication in name
			['/acme/www/index.php', '/acme/www/acme/edit/5', 'acme/edit/5'],
		];
	}
}

(new BaseUrl())->run();