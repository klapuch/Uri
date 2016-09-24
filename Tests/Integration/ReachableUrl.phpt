<?php
/**
 * @testCase
 * @phpVersion > 7.0.0
 */
namespace Klapuch\Uri\Integration;

use Klapuch\Uri;
use Tester\Assert;
use Tester;

require __DIR__ . '/../bootstrap.php';

final class ReachableUrl extends Tester\TestCase {
    protected function existingUrls() {
        return [
            ['http://www.example.com'], // http
            ['https://www.google.com'], // https
            ['https://www.nette.org'], // redirect with 301
        ]; 
    }

    /**
     * @dataProvider existingUrls
     */
    public function testExistingUrls($url) {
        Assert::same(
            $url,
            (new Uri\ReachableUrl(new Uri\FakeUri($url)))->reference()
        );
    }

    protected function unknownUrls() {
        return [
            ['http://www.foobar.foobar'],
            ['ftp://ftp.mirror.nl/'],
        ]; 
    }

    /**
     * @dataProvider unknownUrls
     */
    public function testUnknownUrls($url) {
        Assert::exception(function() use($url) {
            (new Uri\ReachableUrl(new Uri\FakeUri($url)))->reference();
        }, \InvalidArgumentException::class, "The given URL \"$url\" does not exist");
    }

}

(new ReachableUrl())->run();
