<?php
declare(strict_types = 1);
namespace Klapuch\Uri;

/*
 * Valid URL is based on the given protocols
 */
final class ProtocolBasedUrl implements Uri {
    private $origin;
    private $protocols;

    public function __construct(Uri $origin, array $protocols) {
        $this->origin = $origin;
        $this->protocols = $protocols;
    }

    public function reference(): string {
        $scheme = parse_url($this->origin->reference(), PHP_URL_SCHEME);
        if(in_array(strtolower((string)$scheme), $this->protocols))
            return $this->origin->reference();
        throw new \InvalidArgumentException(
            sprintf(
                'Protocol of the URL must be one of %s',
                $this->toReadableProtocols($this->protocols)
            )
        );
    }

	public function path(): string {
		return $this->origin->path();
	}

	/**
     * Protocols transferred to human readable form
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
