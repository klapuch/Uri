<?php
declare(strict_types = 1);
namespace Klapuch\Uri;

/*
 * Valid URL
 */
final class ValidUrl implements Uri {
    private $url;

    public function __construct(string $url) {
        $this->url = $url;
    }

    public function reference(): string {
        if(filter_var($this->url, FILTER_VALIDATE_URL))
            return $this->url;
        throw new \InvalidArgumentException(
            sprintf(
                'The given URL "%s" is not valid',
                $this->url
            )
        );
    }
}
