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

final class NormalizedUrl extends Tester\TestCase {
    protected function urls() {
        // [actual, expected]
        return [
            ['https://www.google.com', 'https://www.google.com'],
            ['httpS://Www.Google.Com', 'https://www.google.com'],
            ['https://www.google.com/', 'https://www.google.com'],
            ['www.google.com/', 'www.google.com'],
            ['google.com/', 'google.com'],
            ['google.com/p/a/t/h', 'google.com/p/a/t/h'],
            ['google.com/p/a/t/h/', 'google.com/p/a/t/h'],
            ['www.google.com?query=value', 'www.google.com?query=value'],
            ['www.google.com?query=', 'www.google.com?query='],
            ['www.google.com#hashTag', 'www.google.com'],
        ]; 
    }

    /**
     * @dataProvider urls
     */
    public function testUrls($actual, $expected) {
        Assert::same(
            $expected,
            (new Uri\NormalizedUrl(new Uri\FakeUri($actual)))->reference()
        );
    }
}

(new NormalizedUrl())->run();
