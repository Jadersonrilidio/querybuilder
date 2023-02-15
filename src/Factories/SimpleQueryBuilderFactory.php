<?php

namespace Jayrods\QueryBuilder\Factories;

use InvalidArgumentException;
use Jayrods\QueryBuilder\Builders\Simple\{
    DeleteQueryBuilder,
    InsertQueryBuilder,
    SelectQueryBuilder,
    UpdateQueryBuilder
};
use Jayrods\QueryBuilder\Builders\QueryBuilderInterface;
use Jayrods\QueryBuilder\Factories\QueryBuilderFactoryInterface;

class SimpleQueryBuilderFactory implements QueryBuilderFactoryInterface
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
                return new DeleteQueryBuilder();
            case self::INSERT:
                return new InsertQueryBuilder();
            case self::SELECT:
                return new SelectQueryBuilder();
            case self::UPDATE:
                return new UpdateQueryBuilder();
            default:
                throw new InvalidArgumentException('builder mode not found');
        }
    }
}
