<?php
declare(strict_types = 1);
namespace Klapuch\Uri;

/*
 * URI which is always reachable
 */
final class AccessibleUri implements Uri {
    const NOT_FOUND = 404;
    private $uri;

    public function __construct(string $uri) {
        $this->uri = $uri;
    }

    public function reference(): string {
        $headers = @get_headers($this->uri);
        if($headers && strpos($headers[0], self::NOT_FOUND) === false)
            return $this->uri;
        throw new \InvalidArgumentException(
            sprintf(
                'The given URI "%s" does not exist',
                $this->uri
            )
        );
    }
}
