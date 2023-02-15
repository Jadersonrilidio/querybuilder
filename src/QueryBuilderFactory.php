<?php

namespace Jayrods\QueryBuilder;

use InvalidArgumentException;
use Jayrods\QueryBuilder\Builders\QueryBuilderInterface;
use Jayrods\QueryBuilder\Factories\{
    ConstrainedQueryBuilderFactory,
    QueryBuilderFactoryInterface,
    SimpleQueryBuilderFactory
};

class QueryBuilderFactory implements QueryBuilderFactoryInterface
{
    public const DELETE = 'delete';
    public const INSERT = 'insert';
    public const SELECT = 'select';
    public const UPDATE = 'update';

    /**
     * Creates an instance of QueryBuilderInterface according to given case.
     * 
     * @throws InvalidArgumentException
     * 
     * @param string $case
     * 
     * @return QueryBuilderInterface
     */
    public function create(string $case): QueryBuilderInterface
    {
        $factory = env('QUERY_BUILDER_ENABLE_STATE_MACHINE', true)
            ? new ConstrainedQueryBuilderFactory
            : new SimpleQueryBuilderFactory;

        return $factory->create($case);
    }
}
