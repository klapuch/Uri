<?php
/**
 * @testCase
 * @phpVersion > 7.0.0
 */
namespace Klapuch\Uri\Unit;

use Klapuch\Uri;
use Tester\Assert;
use Tester;

require __DIR__ . '/../bootstrap.php';

final class BaseUrl extends Tester\TestCase {
    protected function urls() {
        return [
            // [scriptUrl, realUrl, expected]
            ['/foo/www/index.php', '', '/foo/www/'],
            ['/foo/index.php', '', '/foo/'],
            ['/foo/categories/bar/www/index.php', '', '/foo/categories/bar/www/'],
            ['/index.php', '', '/'],
            ['/foo/www/index.php', '/foo/www/how-to', '/foo/www/'],
            ['/foo/www/index.php', '/foo/www/how-to/unit/test/code', '/foo/www/'],
            ['', '/SomeUrl/www/how-to/unit/test/code', '/'],
            ['', '', '/'],
            ['/', '/', '/'],
            ['/foo/index.php', '/foo/index.php', '/foo/'],
            ['index.php', '', '/'],
            ['foo/index.php', '', 'foo/'],
        ];
    }

    /**
     * @dataProvider urls
     */
    public function testChoppedUrls($scriptUrl, $realUrl, $expected) {
        Assert::same(
            (new Uri\BaseUrl($scriptUrl, $realUrl))->reference(),
            $expected
        );
    }
}

(new BaseUrl())->run();
