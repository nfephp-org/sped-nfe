<?php

/*
 * Helpers.
 */

if (!function_exists('config')) {
    /**
     * Simulates the behavior of Laravel's config ().
     *
     * @param string|null $key
     * @param mixed|null $default
     * @return mixed
     */
    function config(?string $key = null, $default = null)
    {
        static $config = [];

        if (empty($config)) {
            $configPath = __DIR__ . '/../Config';
            foreach (glob($configPath . '/*.php') as $file) {
                $config[basename($file, '.php')] = require $file;
            }
        }

        if (is_null($key)) {
            return $config;
        }

        $keys = explode('.', $key);
        $value = $config;

        foreach ($keys as $segment) {
            if (isset($value[$segment])) {
                $value = $value[$segment];
            } else {
                return $default;
            }
        }

        return $value;
    }
}

if (!function_exists('throwIf')) {
    /**
     * Simulates the behavior of Laravel's throwIf ().
     *
     * @param boolean $condition
     * @param string $message
     * @return void
     */
    function throwIf(bool $condition, string $message, ?string $exception = null): void
    {
        $exception = $exception ?: \RuntimeException::class;

        if ($condition) {
            throw new $exception($message);
        }
    }
}

if (!function_exists('env')) {
    /**
     * Simulates the behavior of Laravel's env().
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    function env(string $key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return $default;
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return null;
        }

        if (strlen($value) > 1 && $value[0] === '"' && $value[-1] === '"') {
            return substr($value, 1, -1);
        }

        return $value;
    }
}

if (!function_exists('__')) {
    /**
     * Simulates the behavior of Laravel's __ () for translations.
     *
     * @param string $key
     * @param array $replace
     * @param string|null $locale
     * @return string
     */
    function __($key, array $replace = [], ?string $locale = null): string
    {
        $locale = $locale ?: config('app.locale');

        $baseDir = __DIR__ . '/../Lang/' . $locale;

        // Split key by dot notation: 'file.key1.key2'
        $segments = explode('.', $key);
        $file = array_shift($segments);
        $langFile = $baseDir . '/' . $file . '.php';
        if (!file_exists($langFile)) {
            return $key;
        }

        $translations = require $langFile;

        $line = $translations;
        foreach ($segments as $segment) {
            if (is_array($line) && array_key_exists($segment, $line)) {
                $line = $line[$segment];
            } else {
                return $key;
            }
        }

        if (!is_string($line)) {
            return $key;
        }

        foreach ($replace as $search => $value) {
            $line = str_replace(':' . $search, $value, $line);
        }

        return $line;
    }
}
