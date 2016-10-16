<?php
namespace Klapuch\Uri;

/**
 * Base URL considered as a root URL for project
 */
final class BaseUrl implements Uri {
    const DELIMITER = '/';
    private $script;

    public function __construct(string $script) {
        $this->script = $script;
    }

    public function reference(): string {
        return implode(
            self::DELIMITER,
            $this->withoutExecutedScript(
                explode(self::DELIMITER, $this->script)
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
