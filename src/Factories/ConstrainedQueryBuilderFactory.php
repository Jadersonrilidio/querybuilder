<?php

namespace Jayrods\QueryBuilder\Factories;

use InvalidArgumentException;
use Jayrods\QueryBuilder\Builders\Constrained\{
    ConstrainedDeleteQueryBuilder,
    ConstrainedInsertQueryBuilder,
    ConstrainedSelectQueryBuilder,
    ConstrainedUpdateQueryBuilder
};
use Jayrods\QueryBuilder\Builders\QueryBuilderInterface;
use Jayrods\QueryBuilder\Factories\QueryBuilderFactoryInterface;

class ConstrainedQueryBuilderFactory implements QueryBuilderFactoryInterface
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
        switch ($case) {
            case self::DELETE:
                return new ConstrainedDeleteQueryBuilder();
            case self::INSERT:
                return new ConstrainedInsertQueryBuilder();
            case self::SELECT:
                return new ConstrainedSelectQueryBuilder();
            case self::UPDATE:
                return new ConstrainedUpdateQueryBuilder();
            default:
                throw new InvalidArgumentException('builder mode not found');
        }
    }
}
