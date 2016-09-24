<?php
declare(strict_types = 1);
namespace Klapuch\Uri;

/*
 * URL which is always reachable
 */
final class ReachableUrl implements Uri {
    const STATUS = 0;
    const NOT_FOUND = 404;
    private $origin;

    public function __construct(Uri $origin) {
        $this->origin = $origin;
    }

    public function reference(): string {
        if($this->reachable())
            return $this->origin->reference();
        throw new \InvalidArgumentException(
            sprintf(
                'The given URL "%s" does not exist',
                $this->origin->reference()
            )
        );
    }

    /**
     * Is the URL reachable?
     * @return bool
     */
    private function reachable(): bool {
        $headers = @get_headers($this->origin->reference());
        return $headers
        && strpos($headers[self::STATUS], self::NOT_FOUND) === false;
    }
}
