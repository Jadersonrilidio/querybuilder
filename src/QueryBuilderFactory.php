<?php

namespace Jayrods\QueryBuilder;

use InvalidArgumentException;
use Jayrods\QueryBuilder\{DeleteQueryBuilder, InsertQueryBuilder, SelectQueryBuilder, UpdateQueryBuilder};
use Jayrods\QueryBuilder\QueryBuilder;

class QueryBuilderFactory
{
    public const DELETE = 'delete';
    public const INSERT = 'insert';
    public const SELECT = 'select';
    public const UPDATE = 'update';

    /**
     * Creates an instance of QueryBuilder according to given case.
     * 
     * @throws InvalidArgumentException
     * 
     * @param string $case
     * 
     * @return QueryBuilder
     */
    public function create(string $case): QueryBuilder
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
