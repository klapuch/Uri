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

final class BaseUrl extends Tester\TestCase {
	/**
	 * @dataProvider paths
	 */
	public function testChoppedPaths($script, $url, $path) {
		Assert::same($path, (new Uri\BaseUrl($script, $url))->path());
	}

	/**
	 * @dataProvider urls
	 */
	public function testChoppedUrls($script, $reference) {
		Assert::same(
			$reference,
			(new Uri\BaseUrl($script, 'doesn\'t matter'))->reference()
		);
	}

	protected function urls() {
		return [
			// [scriptUrl expected]
			['/foo/www/index.php', '/foo/www/'],
			['/foo/index.php', '/foo/'],
			['/foo/categories/bar/www/index.php', '/foo/categories/bar/www/'],
			['/index.php', '/'],
			['/foo/www/index.php', '/foo/www/'],
			['/foo/www/index.php', '/foo/www/'],
			['', '/'],
			['', '/'],
			['/', '/'],
			['/foo/index.php', '/foo/'],
			['index.php', '/'],
			['foo/index.php', 'foo/'],
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
			['/Acme/www/index.php', '/acme/www/page/view', 'page/view'], // case sensitive bug
			['/acme/www/index.php', '/Acme/www/page/view', 'page/view'], // case sensitive bug
			['/čcme/www/index.php', '/Čcme/www/page/view', 'page/view'], // multi byte char
			['/acme/www/index.php', '/acme/www/page/view/?get=someValue', 'page/view'],
			['/acme/www/index.php', '/acme/www/page/?get=someValue', 'page'],
			['/acme/www/index.php', '/acme/www/page/view?get=someValue', 'page'],
			['/acme/www/index.php', '/acme/www/page/view/1/?get=someValue', 'page/view/1'],
			['index.php', '/page/view/', 'page/view'],
			['/index.php/', '/page/view/', 'page/view'],
			['/index.php/', '/page/view/view/page', 'page/view/view/page'], // there may be duplication in name
			['/acme/www/index.php', '/acme/www/acme/edit/5', 'acme/edit/5'],
		];
	}
}

(new BaseUrl())->run();
