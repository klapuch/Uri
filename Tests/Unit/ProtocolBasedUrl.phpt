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

final class ProtocolBasedUrl extends Tester\TestCase {
    protected function protocolBasedUrls() {
        return [
            ['http://www.google.com'],
            ['https://www.google.com'],
            ['httpS://Www.Google.Com'],
            ['https://google.com'],
            ['www.google.com/'],
            ['google.com/'],
        ]; 
    }

    /**
     * @dataProvider protocolBasedUrls
     */
    public function testProtocolBasedUrlWithoutError($url) {
        Assert::same(
            $url,
            (new Uri\ProtocolBasedUrl(
                new Uri\FakeUri($url),
                ['http', 'https', '']
            ))->reference()
        );
    }

    protected function nonProtocolBasedUrls() {
        return [
            ['ftp://server.com'],
            ['httpr://server.com'],
        ]; 
    }

    /**
     * @dataProvider nonProtocolBasedUrls
     */
    public function testNonProtocolBasedUrlsWithError($url) {
        Assert::exception(
            function() use($url) {
                (new Uri\ProtocolBasedUrl(
                    new Uri\FakeUri($url),
                    ['http', 'https']
                ))->reference();
            },
            \InvalidArgumentException::class,
            'Protocol of the URL must be one of http, https'
        );
        Assert::exception(
            function() use($url) {
                (new Uri\ProtocolBasedUrl(
                    new Uri\FakeUri($url),
                    ['http', 'https', '']
                ))->reference();
            },
            \InvalidArgumentException::class,
            'Protocol of the URL must be one of http, https or left empty'
        );

    }

}

(new ProtocolBasedUrl())->run();
