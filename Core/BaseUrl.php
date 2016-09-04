<?php
namespace Klapuch\Uri;

final class BaseUrl implements Uri {
    const DELIMITER = '/';
    private $scriptUrl;
    private $realUrl;

    public function __construct(string $scriptUrl, string $realUrl) {
        $this->scriptUrl = $scriptUrl;
        $this->realUrl = $realUrl;
    }

    public function reference(): string {
        return implode(
            self::DELIMITER,
            $this->withoutExecutedScript(
                explode(self::DELIMITER, $this->scriptUrl)
            )
        ) . self::DELIMITER;
    }

    /**
     * Parts of the url without index.php or other file where is scripts executed 
     * @param array $parts
     * @return array
     */
    private function withoutExecutedScript(array $parts): array {
        array_pop($parts);
        return $parts;
    }
}
