<?php

namespace Jayrods\QueryBuilder\Factories;

use Jayrods\QueryBuilder\Builders\QueryBuilderInterface;

interface QueryBuilderFactoryInterface
{
    /**
     * Creates an instance of QueryBuilderInterface according to given case.
     * 
     * @throws InvalidArgumentException
     * 
     * @param string $case
     * 
     * @return QueryBuilderInterface
     */
    public function create(string $case): QueryBuilderInterface;
}
