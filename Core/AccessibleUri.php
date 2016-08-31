<?php
declare(strict_types = 1);
namespace Klapuch\Uri;

/*
 * URI which is always reachable
 */
final class AccessibleUri implements Uri {
    const NOT_FOUND = 404;
    private $origin;

    public function __construct(Uri $origin) {
        $this->origin = $origin;
    }

    public function reference(): string {
        $headers = @get_headers($this->origin->reference());
        if($headers && strpos($headers[0], self::NOT_FOUND) === false)
            return $this->origin->reference();
        throw new \InvalidArgumentException(
            sprintf(
                'The given URI "%s" does not exist',
                $this->origin->reference()
            )
        );
    }
}
