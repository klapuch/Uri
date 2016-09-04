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
            ['/SomeUrl/www/index.php', '', '/SomeUrl/www/'],
            ['/SomeUrl/index.php', '', '/SomeUrl/'],
            ['/Some/2/Url/www/index.php', '', '/Some/2/Url/www/'],
            ['/index.php', '', '/'],
            ['/SomeUrl/www/index.php', '/SomeUrl/www/how-to', '/SomeUrl/www/'],
            ['/SomeUrl/www/index.php', '/SomeUrl/www/how-to/find/your/soul', '/SomeUrl/www/'],
        ];
    }

    /**
     * @dataProvider urls
     */
    public function testCorrectlyChoppedUrls($scriptUrl, $realUrl, $expected) {
        Assert::same(
            (new Uri\BaseUrl($scriptUrl, $realUrl))->reference(),
            $expected
        );
    }
}

(new BaseUrl())->run();
