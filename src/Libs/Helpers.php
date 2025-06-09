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
            $configPath = __DIR__ . '/config';
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
