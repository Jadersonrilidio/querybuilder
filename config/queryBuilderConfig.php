<?php

use Jayrods\QueryBuilder\Utils\Environment as Env;

return [
    /**
     * Enable use of queryBuilder constrained mode.
     */
    'ENABLE_CONSTRAINED_MODE' => Env::get('QB_ENABLE_CONSTRAINED_MODE', true),

    /**
     * Enable constrained mode to throw an exception on fail.
     */
    'FAIL_ON_WRONG_METHOD_CALL' => Env::get('QB_FAIL_ON_WRONG_METHOD_CALL', false),

    /**
     * Enable constrained mode to echo exception message information on fail.
     */
    'ECHO_WARNINGS_ON_WRONG_METHOD_CALL' => Env::get('QB_ECHO_WARNINGS_ON_WRONG_METHOD_CALL', true),

    /**
     * Enable custom named parameters if true or question mark if false.
     */
    'PARAMETERIZED_MODE' => Env::get('QB_PARAMETERIZED_MODE', true),

    /**
     * Enable to throw an exception on fail.
     */
    'PARAMETERIZED_MODE_FAIL_ON_ERROR' => Env::get('QB_PARAMETERIZED_MODE_FAIL_ON_ERROR', true),

    /**
     * Enable to echo exception message information on fail.
     */
    'PARAMETERIZED_MODE_ECHO_WARNINGS_ON_ERROR' => Env::get('QB_PARAMETERIZED_MODE_ECHO_WARNINGS_ON_ERROR', false),
];
