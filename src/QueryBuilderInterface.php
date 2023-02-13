<?php

namespace Jayrods\QueryBuilder;

interface QueryBuilderInterface
{
    /**
     * Return the built query and reset the paratemers to default value.
     * 
     * @return string The SQL query.
     */
    public function build(): string;
}
