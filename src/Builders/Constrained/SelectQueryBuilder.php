<?php

namespace Jayrods\QueryBuilder\Builders\Constrained;

use Jayrods\QueryBuilder\Builders\Constrained\ConstrainedQueryBuilder;
use Jayrods\QueryBuilder\Builders\Simple\SelectQueryBuilder as SimpleSelectQueryBuilder;
use Jayrods\QueryBuilder\Exceptions\{
    DuplicatedMethodCallException,
    InvalidOperatorException,
    RepeatedBinderNameException,
    WrongStateMethodCallException
};
use Jayrods\QueryBuilder\Utils\{
    ConstraintErrorHandler,
    MethodRecordHelper,
    StateMachine
};

class SelectQueryBuilder extends ConstrainedQueryBuilder
{
    /**
     * SelectQueryBuilder instance.
     *
     * @var SimpleSelectQueryBuilder
     */
    private SimpleSelectQueryBuilder $builder;

    /**
     * Class constructor.
     *
     * @param StateMachine $state
     * @param MethodRecordHelper $methodRercord
     * @param ConstraintErrorHandler $errorHandler
     * @param SimpleSelectQueryBuilder $builder
     *
     * @return void
     */
    public function __construct(
        StateMachine $state,
        MethodRecordHelper $methodRercord,
        ConstraintErrorHandler $errorHandler,
        SimpleSelectQueryBuilder $builder
    ) {
        parent::__construct($state, $methodRercord, $errorHandler);

        $this->builder = $builder;
    }

    /**
     * Start building SELECT FROM query.
     *
     * @param string $table
     *
     * @throws WrongStateMethodCallException
     *
     * @return SelectQueryBuilder
     */
    public function selectFrom(string $table): self
    {
        if (!$this->state->checkEquals(self::STATE_ZERO)) {
            $this->errorHandler->wrongStateMethodCall(__METHOD__, 'Building proccess already started');
            return $this;
        }

        $this->state->up();

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->selectFrom($table);

        return $this;
    }

    /**
     * Add column to be selected.
     *
     * @param string $column
     * @param ?string $refTable If the column comes from a relationship, thus the table name must be inserted.
     *
     * @throws WrongStateMethodCallException
     *
     * @return SelectQueryBuilder
     */
    public function column(string $column, ?string $refTable = null): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE)) {
            $this->errorHandler->wrongStateMethodCall(__METHOD__);
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->column($column, $refTable);

        return $this;
    }

    /**
     * Add column with AS clause to be selected.
     *
     * @param string $column
     * @param string $as
     * @param ?string $refTable If the column comes from a relationship, thus the table name must be inserted.
     *
     * @throws WrongStateMethodCallException
     *
     * @return SelectQueryBuilder
     */
    public function columnAs(string $column, string $as, ?string $refTable = null): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE)) {
            $this->errorHandler->wrongStateMethodCall(__METHOD__);
            return $this;
        }
        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->columnAs($column, $as, $refTable);

        return $this;
    }

    /**
     * Start WHERE clause.
     *
     * @param string $column
     * @param string $operator
     * @param ?string $binder
     *
     * @throws InvalidOperatorException|RepeatedBinderNameException|WrongStateMethodCallException
     *
     * @return SelectQueryBuilder
     */
    public function where(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE)) {
            $this->errorHandler->wrongStateMethodCall(__METHOD__, 'Or WHERE clause already started');
            return $this;
        }

        $this->state->up();

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->where($column, $operator, $binder);

        return $this;
    }

    /**
     * Start WHERE IN clause.
     *
     * @param string $column
     * @param string $subquery
     *
     * @throws RepeatedBinderNameException|WrongStateMethodCallException
     *
     * @return SelectQueryBuilder
     */
    public function whereIn(string $column, string $subquery): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE)) {
            $this->errorHandler->wrongStateMethodCall(__METHOD__, 'Or WHERE clause already started');
            return $this;
        }

        $this->state->up();

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->whereIn($column, $subquery);

        return $this;
    }

    /**
     * Start WHERE NOT IN clause.
     *
     * @param string $column
     * @param string $subquery
     *
     * @throws RepeatedBinderNameException|WrongStateMethodCallException
     *
     * @return SelectQueryBuilder
     */
    public function whereNotIn(string $column, string $subquery): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE)) {
            $this->errorHandler->wrongStateMethodCall(__METHOD__, 'Or WHERE clause already started');
            return $this;
        }

        $this->state->up();

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->whereNotIn($column, $subquery);

        return $this;
    }

    /**
     * Start WHERE NOT clause.
     *
     * @param string $column
     * @param string $operator
     * @param ?string $binder
     *
     * @throws InvalidOperatorException|RepeatedBinderNameException|WrongStateMethodCallException
     *
     * @return SelectQueryBuilder
     */
    public function whereNot(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE)) {
            $this->errorHandler->wrongStateMethodCall(__METHOD__, 'Or WHERE clause already started');
            return $this;
        }

        $this->state->up();

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->whereNot($column, $operator, $binder);

        return $this;
    }

    /**
     * Start WHERE BETWEEN clause.
     *
     * @param string $column
     * @param ?string $left
     * @param ?string $right
     *
     * @throws RepeatedBinderNameException|WrongStateMethodCallException
     *
     * @return SelectQueryBuilder
     */
    public function whereBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE)) {
            $this->errorHandler->wrongStateMethodCall(__METHOD__, 'Or WHERE clause already started');
            return $this;
        }

        $this->state->up();

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->whereBetween($column, $left, $right);

        return $this;
    }

    /**
     * Start WHERE NOT BETWEEN clause.
     *
     * @param string $column
     * @param ?string $left
     * @param ?string $right
     *
     * @throws RepeatedBinderNameException|WrongStateMethodCallException
     *
     * @return SelectQueryBuilder
     */
    public function whereNotBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE)) {
            $this->errorHandler->wrongStateMethodCall(__METHOD__, 'Or WHERE clause already started');
            return $this;
        }

        $this->state->up();

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->whereNotBetween($column, $left, $right);

        return $this;
    }

    /**
     * Add AND clause to conditions.
     *
     * @param string $column
     * @param string $operator
     * @param ?string $binder
     *
     * @throws InvalidOperatorException|RepeatedBinderNameException|WrongStateMethodCallException
     *
     * @return SelectQueryBuilder
     */
    public function and(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->state->checkEquals(self::SECOND_STATE)) {
            $this->errorHandler->wrongStateMethodCall(__METHOD__, 'Must start WHERE clause first');
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->and($column, $operator, $binder);

        return $this;
    }

    /**
     * Add AND NOT clause to conditions.
     *
     * @param string $column
     * @param string $operator
     * @param ?string $binder
     *
     * @throws InvalidOperatorException|RepeatedBinderNameException|WrongStateMethodCallException
     *
     * @return SelectQueryBuilder
     */
    public function andNot(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->state->checkEquals(self::SECOND_STATE)) {
            $this->errorHandler->wrongStateMethodCall(__METHOD__, 'Must start WHERE clause first');
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->andNot($column, $operator, $binder);

        return $this;
    }

    /**
     * Add AND BETWEEN clause to conditions.
     *
     * @param string $column
     * @param ?string $left
     * @param ?string $right
     *
     * @throws RepeatedBinderNameException|WrongStateMethodCallException
     *
     * @return SelectQueryBuilder
     */
    public function andBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        if (!$this->state->checkEquals(self::SECOND_STATE)) {
            $this->errorHandler->wrongStateMethodCall(__METHOD__, 'Must start WHERE clause first');
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->andBetween($column, $left, $right);

        return $this;
    }

    /**
     * Add AND NOT BETWEEN clause to conditions.
     *
     * @param string $column
     * @param ?string $left
     * @param ?string $right
     *
     * @throws RepeatedBinderNameException|WrongStateMethodCallException
     *
     * @return SelectQueryBuilder
     */
    public function andNotBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        if (!$this->state->checkEquals(self::SECOND_STATE)) {
            $this->errorHandler->wrongStateMethodCall(__METHOD__, 'Must start WHERE clause first');
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->andNotBetween($column, $left, $right);

        return $this;
    }

    /**
     * Add OR clause to conditions.
     *
     * @param string $column
     * @param string $operator
     * @param ?string $binder
     *
     * @throws InvalidOperatorException|RepeatedBinderNameException|WrongStateMethodCallException
     *
     * @return SelectQueryBuilder
     */
    public function or(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->state->checkEquals(self::SECOND_STATE)) {
            $this->errorHandler->wrongStateMethodCall(__METHOD__, 'Must start WHERE clause first');
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->or($column, $operator, $binder);

        return $this;
    }

    /**
     * Add OR NOT clause to conditions.
     *
     * @param string $column
     * @param string $operator
     * @param ?string $binder
     *
     * @throws InvalidOperatorException|RepeatedBinderNameException|WrongStateMethodCallException
     *
     * @return SelectQueryBuilder
     */
    public function orNot(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->state->checkEquals(self::SECOND_STATE)) {
            $this->errorHandler->wrongStateMethodCall(__METHOD__, 'Must start WHERE clause first');
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->orNot($column, $operator, $binder);

        return $this;
    }

    /**
     * Add OR BETWEEN clause to conditions.
     *
     * @param string $column
     * @param ?string $left
     * @param ?string $right
     *
     * @throws RepeatedBinderNameException|WrongStateMethodCallException
     *
     * @return SelectQueryBuilder
     */
    public function orBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        if (!$this->state->checkEquals(self::SECOND_STATE)) {
            $this->errorHandler->wrongStateMethodCall(__METHOD__, 'Must start WHERE clause first');
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->orBetween($column, $left, $right);

        return $this;
    }

    /**
     * Add OR NOT BETWEEN clause to conditions.
     *
     * @param string $column
     * @param ?string $left
     * @param ?string $right
     *
     * @throws RepeatedBinderNameException|WrongStateMethodCallException
     *
     * @return SelectQueryBuilder
     */
    public function orNotBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        if (!$this->state->checkEquals(self::SECOND_STATE)) {
            $this->errorHandler->wrongStateMethodCall(__METHOD__, 'Must start WHERE clause first');
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->orNotBetween($column, $left, $right);

        return $this;
    }

    /**
     * Add LIMIT clause.
     *
     * @param int $limit
     *
     * @throws DuplicatedMethodCallException|WrongStateMethodCallException
     *
     * @return SelectQueryBuilder
     */
    public function limit(int $limit): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE, self::SECOND_STATE)) {
            $this->errorHandler->wrongStateMethodCall(__METHOD__);
            return $this;
        }

        if ($this->methodRercord->methodCalledOnce(__METHOD__)) {
            $this->errorHandler->duplicatedMethodCall(__METHOD__, 'LIMIT clause already set');
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->limit($limit);

        return $this;
    }

    /**
     * Add ORDER BY clause.
     *
     * @param string $column
     *
     * @throws DuplicatedMethodCallException|WrongStateMethodCallException
     *
     * @return SelectQueryBuilder
     */
    public function orderBy(string $column): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE, self::SECOND_STATE)) {
            $this->errorHandler->wrongStateMethodCall(__METHOD__);
            return $this;
        }

        if ($this->methodRercord->methodCalledOnce(__METHOD__)) {
            $this->errorHandler->duplicatedMethodCall(__METHOD__, 'ORDER BY clause already set');
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->orderBy($column);

        return $this;
    }

    /**
     * Sort the result order ascending.
     *
     * @throws DuplicatedMethodCallException|WrongStateMethodCallException
     *
     * @return SelectQueryBuilder
     */
    public function asc(): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE, self::SECOND_STATE)) {
            $this->errorHandler->wrongStateMethodCall(__METHOD__);
            return $this;
        }

        if ($this->methodRercord->methodCalledOnce(__METHOD__, 'desc')) {
            $this->errorHandler->duplicatedMethodCall(__METHOD__, 'sorting order already set');
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->asc();

        return $this;
    }

    /**
     * Sort the result order descending.
     *
     * @throws DuplicatedMethodCallException|WrongStateMethodCallException
     *
     * @return SelectQueryBuilder
     */
    public function desc(): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE, self::SECOND_STATE)) {
            $this->errorHandler->wrongStateMethodCall(__METHOD__);
            return $this;
        }

        if ($this->methodRercord->methodCalledOnce(__METHOD__, 'asc')) {
            $this->errorHandler->duplicatedMethodCall(__METHOD__, 'sorting order already set');
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->desc();

        return $this;
    }

    /**
     * Add INNER JOIN clause.
     *
     * @param string $joinTable
     * @param string $columnTable
     * @param string $operator
     * @param string $columnJoinTable
     *
     * @throws InvalidOperatorException|WrongStateMethodCallException
     *
     * @return SelectQueryBuilder
     */
    public function innerJoin(string $joinTable, string $columnTable, string $operator, string $columnJoinTable): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE)) {
            $this->errorHandler->wrongStateMethodCall(__METHOD__);
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->innerJoin($joinTable, $columnTable, $operator, $columnJoinTable);

        return $this;
    }

    /**
     * Add LEFT JOIN clause.
     *
     * @param string $joinTable
     * @param string $columnTable
     * @param string $operator
     * @param string $columnJoinTable
     *
     * @throws InvalidOperatorException|WrongStateMethodCallException
     *
     * @return SelectQueryBuilder
     */
    public function leftJoin(string $joinTable, string $columnTable, string $operator, string $columnJoinTable): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE)) {
            $this->errorHandler->wrongStateMethodCall(__METHOD__);
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->leftJoin($joinTable, $columnTable, $operator, $columnJoinTable);

        return $this;
    }

    /**
     * Add RIGHT JOIN clause.
     *
     * @param string $joinTable
     * @param string $columnTable
     * @param string $operator
     * @param string $columnJoinTable
     *
     * @throws InvalidOperatorException|WrongStateMethodCallException
     *
     * @return SelectQueryBuilder
     */
    public function rightJoin(string $joinTable, string $columnTable, string $operator, string $columnJoinTable): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE)) {
            $this->errorHandler->wrongStateMethodCall(__METHOD__);
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->rightJoin($joinTable, $columnTable, $operator, $columnJoinTable);

        return $this;
    }

    /**
     * Return the built query and reset all attributes and helpers to default value.
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

    /**
     * Return array with BindParam names acresced by ':' notation.
     *
     * @return string[]
     */
    public function getBindParams(): array
    {
        return $this->builder->getBindParams();
    }
}
