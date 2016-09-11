<?php
declare(strict_types = 1);
namespace Klapuch\Uri;

/*
 * Fake URI
 */
final class FakeUri implements Uri {
    private $uri;

    public function __construct(string $uri = null) {
        $this->uri = $uri;
    }

    public function reference(): string {
        return $this->uri;
    }
}
