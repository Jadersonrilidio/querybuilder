<?php

namespace Jayrods\QueryBuilder\Utils;

class Environment
{
    /**
     * Get environment variable or return default value.
     *
     * @param string $env
     * @param $default
     *
     * @return mixed
     */
    public static function get(string $env, $default = null)
    {
        if (!isset($_ENV[$env]) and !is_string(getenv($env))) {
            return $default;
        }

        $value = $_ENV[$env] ?? getenv($env);

        if (preg_match('/^[0-9]+$/', $value)) {
            return (int) $value;
        }

        if (preg_match('/^[0-9]+\.[0-9]+$/', $value)) {
            return (float) $value;
        }

        if ($value === 'true') {
            return true;
        }

        if ($value === 'false') {
            return false;
        }

        if ($value === 'null') {
            return null;
        }

        return $value;
    }
}
