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
    function throwIf(bool $condition, string $message): void
    {
        if ($condition) {
            throw new \RuntimeException($message);
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
