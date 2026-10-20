<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Environment Loader
 *
 * Reads a .env file (if present) and exposes values through an
 * environment accessor. Real environment variables always win over
 * .env entries, so a hosting panel's variable editor overrides the file.
 *
 * Never commit a .env file. .env is already covered by .gitignore.
 */

final class Env
{
    /** @var array<string,string> */
    private static array $values = [];
    private static bool $loaded = false;

    public static function load(string $path): void
    {
        if (self::$loaded) {
            return;
        }
        self::$loaded = true;

        if (!is_file($path) || !is_readable($path)) {
            return;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false) {
            return;
        }

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }
            if (str_starts_with($line, 'export ')) {
                $line = substr($line, 7);
            }

            $eq = strpos($line, '=');
            if ($eq === false) {
                continue;
            }

            $key = trim(substr($line, 0, $eq));
            $value = trim(substr($line, $eq + 1));

            if ($key === '') {
                continue;
            }

            // Strip matching surrounding quotes.
            $len = strlen($value);
            if ($len >= 2) {
                $first = $value[0];
                $last = $value[$len - 1];
                if (($first === '"' && $last === '"') || ($first === "'" && $last === "'")) {
                    $value = substr($value, 1, -1);
                    if ($first === '"') {
                        $value = str_replace(['\\"', '\\n', '\\r', '\\t'], ['"', "\n", "\r", "\t"], $value);
                    }
                }
            }

            self::$values[$key] = $value;
        }
    }

    /**
     * Read a configuration value.
     *
     * Order: real environment variable, then .env file, then $default.
     */
    public static function get(string $key, ?string $default = null): ?string
    {
        $env = getenv($key);
        if (is_string($env) && $env !== '') {
            return $env;
        }
        if (isset(self::$values[$key]) && self::$values[$key] !== '') {
            return self::$values[$key];
        }
        return $default;
    }

    public static function bool(string $key, bool $default = false): bool
    {
        $value = self::get($key);
        if ($value === null) {
            return $default;
        }
        return in_array(strtolower($value), ['1', 'true', 'yes', 'on'], true);
    }

    public static function int(string $key, int $default = 0): int
    {
        $value = self::get($key);
        return ($value !== null && is_numeric($value)) ? (int) $value : $default;
    }
}
