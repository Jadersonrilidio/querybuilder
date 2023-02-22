<?php

namespace Jayrods\QueryBuilder\Traits;

trait ValidateOperator
{
    /**
     * Check whether the operator sign is valid or not.
     *
     * @param string $operator
     *
     * @return bool
     */
    protected function isValidOperator(string $operator): bool
    {
        return in_array(
            strtoupper($operator),
            ['=', '<>', '>', '<', '>=', '<=', 'LIKE'],
            true
        );
    }
}
