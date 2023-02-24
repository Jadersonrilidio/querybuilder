<?php

namespace Jayrods\QueryBuilder\Builders\Constrained;

use Jayrods\QueryBuilder\Builders\Constrained\ConstrainedQueryBuilder;
use Jayrods\QueryBuilder\Builders\Simple\DeleteQueryBuilder as SimpleDeleteQueryBuilder;
use Jayrods\QueryBuilder\Exceptions\{
    InvalidOperatorException,
    RepeatedBinderNameException,
    WrongStateMethodCallException
};
use Jayrods\QueryBuilder\Utils\{
    ConstraintErrorHandler,
    MethodRecordHelper,
    StateMachine
};

class DeleteQueryBuilder extends ConstrainedQueryBuilder
{
    /**
     * DeleteQueryBuilder instance.
     *
     * @var SimpleDeleteQueryBuilder
     */
    private SimpleDeleteQueryBuilder $builder;

    /**
     * Class constructor.
     *
     * @param StateMachine $state
     * @param MethodRecordHelper $methodRercord
     * @param ConstraintErrorHandler $errorHandler
     * @param SimpleDeleteQueryBuilder $builder
     *
     * @return void
     */
    public function __construct(
        StateMachine $state,
        MethodRecordHelper $methodRercord,
        ConstraintErrorHandler $errorHandler,
        SimpleDeleteQueryBuilder $builder
    ) {
        parent::__construct($state, $methodRercord, $errorHandler);

        $this->builder = $builder;
    }

    /**
     * Start building DELETE query.
     *
     * @param string $table
     *
     * @throws WrongStateMethodCallException
     *
     * @return DeleteQueryBuilder
     */
    public function delete(string $table): self
    {
        if (!$this->state->checkEquals(self::STATE_ZERO)) {
            $this->errorHandler->wrongStateMethodCall(__METHOD__, 'Building proccess already started');
            return $this;
        }

        $this->state->up();

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->delete($table);

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
     * @return DeleteQueryBuilder
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
     * @throws WrongStateMethodCallException
     *
     * @return DeleteQueryBuilder
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
     * @throws WrongStateMethodCallException
     *
     * @return DeleteQueryBuilder
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
     * @return DeleteQueryBuilder
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
     * @return DeleteQueryBuilder
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
     * @return DeleteQueryBuilder
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
     * @return DeleteQueryBuilder
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
     * @return DeleteQueryBuilder
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
     * @return DeleteQueryBuilder
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
     * @return DeleteQueryBuilder
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
     * @return DeleteQueryBuilder
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
     * @return DeleteQueryBuilder
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
     * @return DeleteQueryBuilder
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
     * @return DeleteQueryBuilder
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
