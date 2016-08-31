<?php
declare(strict_types = 1);
namespace Klapuch\Uri;

/*
 * Valid URL based on the given protocols
 */
final class ProtocolBasedUrl implements Uri {
    private $url;
    private $protocols;

    public function __construct(string $url, array $protocols) {
        $this->url = $url;
        $this->protocols = $protocols;
    }

    public function reference(): string {
        $scheme = parse_url($this->url, PHP_URL_SCHEME) ?? '';
        if(in_array(strtolower($scheme), $this->protocols))
            return $this->url;
        throw new \InvalidArgumentException(
            sprintf(
                'Protocol of the URL must be one of %s',
                $this->toReadableProtocols($this->protocols)
            )
        );
    }

    /**
     * Protocols transferred to human readble phrase
     * @param array $protocols
     * @return string
     */
    private function toReadableProtocols(array $protocols): string {
        $emptyPhrase = ' or left empty';
        $phrase = implode(', ', array_filter($protocols));
        if($protocols === array_filter($protocols))
            return $phrase;
        return $phrase . $emptyPhrase;
    }
}
