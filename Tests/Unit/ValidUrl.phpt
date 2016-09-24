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

final class ValidUrl extends Tester\TestCase {
    protected function validUrls() {
        return [
            ['http://www.google.com'],
            ['http://www.google.com:80'],
            ['http://www.google.com:8080'],
            ['https://www.google.com'],
            ['ftp://www.google.com'],
            ['http://192.168.1.12'],
            ['http://192.168.1.12/some-page'],
        ];
    }

    protected function invalidUrls() {
        return [
            ['localhost'],
            ['127.0.0.1'],
            ['123.45.67.87'],
            ['www.google.com'],
            ['google.com'],
            ['foo'],
        ];
    }

    /**
     * @dataProvider validUrls
     */
    public function testValidUrl($url) {
        Assert::same(
            $url,
            (new Uri\ValidUrl($url))->reference()
        );
    }

    /**
     * @dataProvider invalidUrls
     */
    public function testInvalidUrlWithFail($url) {
        Assert::exception(function() use($url) {
            (new Uri\ValidUrl($url))->reference();
        }, \InvalidArgumentException::class, "The given URL \"$url\" is not valid");
    }
}

(new ValidUrl())->run();
