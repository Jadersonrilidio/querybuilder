<?php

/**
 * Get an environment variable or return default value.
 * 
 * @param string $env
 * @param $default
 * 
 * @return 
 */
function env(string $env, $default = null)
{
    if (!is_string(getenv($env))) {
        return $default;
    }

    $value = getenv($env);

    if (preg_match('/^[0-9]+$/', $value)) {
        return (int) $value;
    }

    if (preg_match('/^[0-9]+\.[0-9]+$/', $value)) {
        return (float) $value;
    }

    if ($value === 'true' or $value === 'false') {
        return (bool) $value;
    }

    if ($value === 'null') {
        return null;
    }

    return $value;
}
