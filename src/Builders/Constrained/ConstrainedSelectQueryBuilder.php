<?php

namespace Jayrods\QueryBuilder\Builders\Constrained;

use Jayrods\QueryBuilder\Builders\QueryBuilderInterface;
use Jayrods\QueryBuilder\Builders\Simple\SelectQueryBuilder;
use Jayrods\QueryBuilder\Utils\MethodRecordHelper;
use Jayrods\QueryBuilder\Utils\StateMachine;

class ConstrainedSelectQueryBuilder implements QueryBuilderInterface
{
    private const STATE_ZERO = 0;
    private const FIRST_STATE = 1;
    private const SECOND_STATE = 2;

    /**
     * StateMachine instance.
     * 
     * @var StateMachine
     */
    private StateMachine $state;

    /**
     * StateMachine instance.
     * 
     * @var MethodRecordHelper
     */
    private MethodRecordHelper $methodRercord;

    /**
     * SelectQueryBuilder instance.
     * 
     * @var SelectQueryBuilder
     */
    private SelectQueryBuilder $builder;

    /**
     * Class constructor.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->state = new StateMachine;
        $this->methodRercord = new MethodRecordHelper;
        $this->builder = new SelectQueryBuilder();
    }

    /**
     * Start building a query to select from into aimed table.
     * 
     * @param string $table
     * 
     * @return ConstrainedSelectQueryBuilder
     */
    public function selectFrom(string $table): self
    {
        if (!$this->state->checkEquals(self::STATE_ZERO)) {
            echo "WARNING: Method 'selectFrom' wrong calling order: machine already started." . PHP_EOL;
            echo "NOTICE: Scaping 'selectFrom' method call." . PHP_EOL;
            return $this;
        }

        $this->state->up();

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->selectFrom($table);

        return $this;
    }

    /**
     * Adds a column to be selected.
     * 
     * @param string $column
     * @param ?string $refTable If the column comes from a relationship, thus the table name must be inserted.
     * 
     * @return ConstrainedSelectQueryBuilder
     */
    public function column(string $column, ?string $refTable = null): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE)) {
            echo "WARNING: Method 'column' wrong calling order." . PHP_EOL;
            echo "NOTICE: Scaping 'column' method call." . PHP_EOL;
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->column($column, $refTable);

        return $this;
    }

    /**
     * Adds a column with AS clause to be selected.
     * 
     * @param string $column
     * @param string $as
     * @param ?string $refTable If the column comes from a relationship, thus the table name must be inserted.
     * 
     * @return ConstrainedSelectQueryBuilder
     */
    public function columnAs(string $column, string $as, ?string $refTable = null): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE)) {
            echo "WARNING: Method 'columnAs' wrong calling order." . PHP_EOL;
            echo "NOTICE: Scaping 'columnAs' method call." . PHP_EOL;
            return $this;
        }
        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->columnAs($column, $as, $refTable);

        return $this;
    }

    /**
     * Starts a WHERE clause.
     * 
     * @param string $column
     * @param string $operator
     * @param ?string $binder
     * 
     * @throws InvalidOperatorException
     * 
     * @return ConstrainedSelectQueryBuilder
     */
    public function where(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE)) {
            echo "WARNING: Method 'where' wrong calling order or WHERE clause already started." . PHP_EOL;
            echo "NOTICE: Scaping 'where' method call." . PHP_EOL;
            return $this;
        }

        $this->state->up();

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->where($column, $operator, $binder);

        return $this;
    }

    /**
     * Starts a WHERE IN clause.
     * 
     * @param string $column
     * @param string $subquery
     * 
     * @return ConstrainedSelectQueryBuilder
     */
    public function whereIn(string $column, string $subquery): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE)) {
            echo "WARNING: Method 'whereIn' wrong calling order or WHERE clause already started." . PHP_EOL;
            echo "NOTICE: Scaping 'whereIn' method call." . PHP_EOL;
            return $this;
        }

        $this->state->up();

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->whereIn($column, $subquery);

        return $this;
    }

    /**
     * Starts a WHERE NOT IN clause.
     * 
     * @param string $column
     * @param string $subquery
     * 
     * @return ConstrainedSelectQueryBuilder
     */
    public function whereNotIn(string $column, string $subquery): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE)) {
            echo "WARNING: Method 'whereNotIn' wrong calling order or WHERE clause already started." . PHP_EOL;
            echo "NOTICE: Scaping 'whereNotIn' method call." . PHP_EOL;
            return $this;
        }

        $this->state->up();

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->whereNotIn($column, $subquery);

        return $this;
    }

    /**
     * Starts a WHERE NOT clause.
     * 
     * @param string $column
     * @param string $operator
     * @param ?string $binder
     * 
     * @throws InvalidOperatorException
     * 
     * @return ConstrainedSelectQueryBuilder
     */
    public function whereNot(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE)) {
            echo "WARNING: Method 'whereNot' wrong calling order or WHERE clause already started." . PHP_EOL;
            echo "NOTICE: Scaping 'whereNot' method call." . PHP_EOL;
            return $this;
        }

        $this->state->up();

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->whereNot($column, $operator, $binder);

        return $this;
    }

    /**
     * Starts a WHERE BETWEEN clause.
     * 
     * @param string $column
     * @param ?string $left
     * @param ?string $right
     * 
     * @return ConstrainedSelectQueryBuilder
     */
    public function whereBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE)) {
            echo "WARNING: Method 'whereBetween' wrong calling order or WHERE clause already started." . PHP_EOL;
            echo "NOTICE: Scaping 'whereBetween' method call." . PHP_EOL;
            return $this;
        }

        $this->state->up();

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->whereBetween($column, $left, $right);

        return $this;
    }

    /**
     * Starts a WHERE NOT BETWEEN clause.
     * 
     * @param string $column
     * @param ?string $left
     * @param ?string $right
     * 
     * @return ConstrainedSelectQueryBuilder
     */
    public function whereNotBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE)) {
            echo "WARNING: Method 'whereNotBetween' wrong calling order or WHERE clause already started." . PHP_EOL;
            echo "NOTICE: Scaping 'whereNotBetween' method call." . PHP_EOL;
            return $this;
        }

        $this->state->up();

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->whereNotBetween($column, $left, $right);

        return $this;
    }

    /**
     * Adds an AND clause to conditions.
     * 
     * @param string $column
     * @param string $operator
     * @param ?string $binder
     * 
     * @throws InvalidOperatorException
     * 
     * @return ConstrainedSelectQueryBuilder
     */
    public function and(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->state->checkEquals(self::SECOND_STATE)) {
            echo "WARNING: Method 'and' wrong calling order. WHERE clause must already be started." . PHP_EOL;
            echo "NOTICE: Scaping 'and' method call." . PHP_EOL;
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->and($column, $operator, $binder);

        return $this;
    }

    /**
     * Adds an AND NOT clause to conditions.
     * 
     * @param string $column
     * @param string $operator
     * @param ?string $binder
     * 
     * @throws InvalidOperatorException
     * 
     * @return ConstrainedSelectQueryBuilder
     */
    public function andNot(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->state->checkEquals(self::SECOND_STATE)) {
            echo "WARNING: Method 'andNot' wrong calling order. WHERE clause must already be started." . PHP_EOL;
            echo "NOTICE: Scaping 'andNot' method call." . PHP_EOL;
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->andNot($column, $operator, $binder);

        return $this;
    }

    /**
     * Adds an AND BETWEEN clause to conditions.
     * 
     * @param string $column
     * @param ?string $left
     * @param ?string $right
     * 
     * @return ConstrainedSelectQueryBuilder
     */
    public function andBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        if (!$this->state->checkEquals(self::SECOND_STATE)) {
            echo "WARNING: Method 'andBetween' wrong calling order. WHERE clause must already be started." . PHP_EOL;
            echo "NOTICE: Scaping 'andBetween' method call." . PHP_EOL;
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->andBetween($column, $left, $right);

        return $this;
    }

    /**
     * Adds an AND NOT BETWEEN clause to conditions.
     * 
     * @param string $column
     * @param ?string $left
     * @param ?string $right
     * 
     * @return ConstrainedSelectQueryBuilder
     */
    public function andNotBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        if (!$this->state->checkEquals(self::SECOND_STATE)) {
            echo "WARNING: Method 'andNotBetween' wrong calling order. WHERE clause must already be started." . PHP_EOL;
            echo "NOTICE: Scaping 'andNotBetween' method call." . PHP_EOL;
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->andNotBetween($column, $left, $right);

        return $this;
    }

    /**
     * Adds an OR clause to conditions.
     * 
     * @param string $column
     * @param string $operator
     * @param ?string $binder
     * 
     * @throws InvalidOperatorException
     * 
     * @return ConstrainedSelectQueryBuilder
     */
    public function or(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->state->checkEquals(self::SECOND_STATE)) {
            echo "WARNING: Method 'or' wrong calling order. WHERE clause must already be started." . PHP_EOL;
            echo "NOTICE: Scaping 'or' method call." . PHP_EOL;
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->or($column, $operator, $binder);

        return $this;
    }

    /**
     * Adds an OR NOT clause to conditions.
     * 
     * @param string $column
     * @param string $operator
     * @param ?string $binder
     * 
     * @throws InvalidOperatorException
     * 
     * @return ConstrainedSelectQueryBuilder
     */
    public function orNot(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->state->checkEquals(self::SECOND_STATE)) {
            echo "WARNING: Method 'orNot' wrong calling order. WHERE clause must already be started." . PHP_EOL;
            echo "NOTICE: Scaping 'orNot' method call." . PHP_EOL;
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->orNot($column, $operator, $binder);

        return $this;
    }

    /**
     * Adds an OR BETWEEN clause to conditions.
     * 
     * @param string $column
     * @param ?string $left
     * @param ?string $right
     * 
     * @return ConstrainedSelectQueryBuilder
     */
    public function orBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        if (!$this->state->checkEquals(self::SECOND_STATE)) {
            echo "WARNING: Method 'orBetween' wrong calling order. WHERE clause must already be started." . PHP_EOL;
            echo "NOTICE: Scaping 'orBetween' method call." . PHP_EOL;
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->orBetween($column, $left, $right);

        return $this;
    }

    /**
     * Adds an OR NOT BETWEEN clause to conditions.
     * 
     * @param string $column
     * @param ?string $left
     * @param ?string $right
     * 
     * @return ConstrainedSelectQueryBuilder
     */
    public function orNotBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        if (!$this->state->checkEquals(self::SECOND_STATE)) {
            echo "WARNING: Method 'orNotBetween' wrong calling order. WHERE clause must already be started." . PHP_EOL;
            echo "NOTICE: Scaping 'orNotBetween' method call." . PHP_EOL;
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->orNotBetween($column, $left, $right);

        return $this;
    }

    /**
     * Set the LIMIT of results.
     * 
     * @param int $limit
     * 
     * @return ConstrainedSelectQueryBuilder
     */
    public function limit(int $limit): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE, self::SECOND_STATE)) {
            echo "WARNING: Method 'limit' wrong calling order" . PHP_EOL;
            echo "NOTICE: Scaping 'limit' method call." . PHP_EOL;
            return $this;
        }

        if ($this->methodRercord->methodCalledOnce(__METHOD__)) {
            echo "WARNING: LIMIT clause is already set." . PHP_EOL;
            echo "NOTICE: Scaping 'limit' method call." . PHP_EOL;
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->limit($limit);

        return $this;
    }

    /**
     * Set the ORDER BY clause.
     * 
     * @param string $column
     * 
     * @return ConstrainedSelectQueryBuilder
     */
    public function orderBy(string $column): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE, self::SECOND_STATE)) {
            echo "WARNING: Method 'orderBy' wrong calling order." . PHP_EOL;
            echo "NOTICE: Scaping 'orderBy' method call." . PHP_EOL;
            return $this;
        }

        if ($this->methodRercord->methodCalledOnce(__METHOD__)) {
            echo "WARNING: ORDER BY clause already set." . PHP_EOL;
            echo "NOTICE: Scaping 'orderBy' method call." . PHP_EOL;
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->orderBy($column);

        return $this;
    }

    /**
     * Sort the result order ascending.
     * 
     * @return ConstrainedSelectQueryBuilder
     */
    public function asc(): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE, self::SECOND_STATE)) {
            echo "WARNING: Method 'asc' wrong calling order." . PHP_EOL;
            echo "NOTICE: Scaping 'asc' method call." . PHP_EOL;
            return $this;
        }

        if ($this->methodRercord->methodCalledOnce(__METHOD__, 'desc')) {
            echo "WARNING: sorting order clause already set." . PHP_EOL;
            echo "NOTICE: Scaping 'asc' method call." . PHP_EOL;
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->asc();

        return $this;
    }

    /**
     * Sort the result order descending.
     * 
     * @return ConstrainedSelectQueryBuilder
     */
    public function desc(): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE, self::SECOND_STATE)) {
            echo "WARNING: Method 'desc' wrong calling order." . PHP_EOL;
            echo "NOTICE: Scaping 'desc' method call." . PHP_EOL;
            return $this;
        }

        if ($this->methodRercord->methodCalledOnce(__METHOD__, 'asc')) {
            echo "WARNING: sorting order clause already set." . PHP_EOL;
            echo "NOTICE: Scaping 'desc' method call." . PHP_EOL;
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->desc();

        return $this;
    }

    /**
     * Adds an INNER JOIN clause.
     * 
     * @param string $joinTable
     * @param string $columnTable
     * @param string $columnJoinTable
     * @param string $operator
     * 
     * @throws InvalidOperatorException
     * 
     * @return ConstrainedSelectQueryBuilder
     */
    public function innerJoin(string $joinTable, string $columnTable, string $columnJoinTable,  string $operator): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE)) {
            echo "WARNING: Method 'innerJoin' wrong calling order." . PHP_EOL;
            echo "NOTICE: Scaping 'innerJoin' method call." . PHP_EOL;
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->innerJoin($joinTable, $columnTable, $columnJoinTable, $operator);

        return $this;
    }

    /**
     * Return the built query and reset the paratemers to default value.
     * 
     * @return string The SQL query.
     */
    public function build(): string
    {
        $this->state->reset();
        $this->methodRercord->resetMethodsCall();

        return $this->builder->build();
    }

    /**
     * Return the last built query or empty string.
     * 
     * @return string
     */
    public function query(): string
    {
        return $this->builder->query();
    }
}
