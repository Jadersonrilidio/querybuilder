<?php

namespace Jayrods\QueryBuilder\Factories;

use InvalidArgumentException;
use Jayrods\QueryBuilder\Builders\QueryBuilderInterface;

interface QueryBuilderFactoryInterface
{
    /**
     * Create instance of QueryBuilderInterface according to given case.
     *
     * @throws InvalidArgumentException
     *
     * @param string $case
     *
     * @return QueryBuilderInterface
     */
    public function create(string $case): QueryBuilderInterface;
}
