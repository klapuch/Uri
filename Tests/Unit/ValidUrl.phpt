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
    public function testValidUrl() {
        $url = 'https://www.google.com';
        Assert::same(
            $url,
            (new Uri\ValidUrl($url))->reference()
        );
    }

    public function testInvalidUrlWithError() {
        Assert::exception(function() {
            (new Uri\ValidUrl('foo'))->reference();
        }, \InvalidArgumentException::class, "The given URL \"foo\" is not valid");
    }
}

(new ValidUrl())->run();
