<?php

namespace Jayrods\QueryBuilder\Builders;

interface QueryBuilderInterface
{
    /**
     * Return the built query and reset the paratemers to default value.
     * 
     * @return string The SQL query.
     */
    public function build(): string;

    /**
     * Return the last built query or empty string.
     * 
     * @return string
     */
    public function query(): string;
}
