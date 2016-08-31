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

final class AccessibleUri extends Tester\TestCase {
    protected function existingUris() {
        return [
            ['http://www.example.com'], // http
            ['https://www.google.com'], // https
            ['https://www.nette.org'], // redirect with 301
        ]; 
    }

    /**
     * @dataProvider existingUris
     */
    public function testExistingUris($uri) {
        Assert::same(
            $uri,
            (new Uri\AccessibleUri($uri))->reference()
        );
    }

    protected function unknownUris() {
        return [
            ['http://www.foobar.foobar'],
        ]; 
    }

    /**
     * @dataProvider unknownUris
     */
    public function testUnknownUris($uri) {
        Assert::exception(function() use($uri) {
            (new Uri\AccessibleUri($uri))->reference();
        }, \InvalidArgumentException::class, "The given URI \"$uri\" does not exist");
    }

}

(new AccessibleUri())->run();
