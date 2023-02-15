<?php

namespace Jayrods\QueryBuilder\Builders\Constrained;

use Jayrods\QueryBuilder\Builders\QueryBuilderInterface;
use Jayrods\QueryBuilder\Builders\Simple\DeleteQueryBuilder;
use Jayrods\QueryBuilder\Utils\MethodRecordHelper;
use Jayrods\QueryBuilder\Utils\StateMachine;

class ConstrainedDeleteQueryBuilder implements QueryBuilderInterface
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
     * @var DeleteQueryBuilder
     */
    private DeleteQueryBuilder $builder;

    /**
     * Class constructor.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->state = new StateMachine;
        $this->methodRercord = new MethodRecordHelper;
        $this->builder = new DeleteQueryBuilder();
    }

    /**
     * Start building a query to select from into aimed table.
     * 
     * @param string $table
     * 
     * @return ConstrainedDeleteQueryBuilder
     */
    public function delete(string $table): self
    {
        if (!$this->state->checkEquals(self::STATE_ZERO)) {
            echo "WARNING: Method called under wrong calling order. Machine already started." . PHP_EOL;
            return $this;
        }

        $this->state->up();

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->delete($table);

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
     * @return ConstrainedDeleteQueryBuilder
     */
    public function where(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE)) {
            echo "WARNING: Method called under wrong calling order or WHERE clause already started." . PHP_EOL;
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
     * @return ConstrainedDeleteQueryBuilder
     */
    public function whereIn(string $column, string $subquery): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE)) {
            echo "WARNING: Method called under wrong calling order or WHERE clause already started." . PHP_EOL;
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
     * @return ConstrainedDeleteQueryBuilder
     */
    public function whereNotIn(string $column, string $subquery): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE)) {
            echo "WARNING: Method called under wrong calling order or WHERE clause already started." . PHP_EOL;
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
     * @return ConstrainedDeleteQueryBuilder
     */
    public function whereNot(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE)) {
            echo "WARNING: Method called under wrong calling order or WHERE clause already started." . PHP_EOL;
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
     * @return ConstrainedDeleteQueryBuilder
     */
    public function whereBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE)) {
            echo "WARNING: Method called under wrong calling order or WHERE clause already started." . PHP_EOL;
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
     * @return ConstrainedDeleteQueryBuilder
     */
    public function whereNotBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE)) {
            echo "WARNING: Method called under wrong calling order or WHERE clause already started." . PHP_EOL;
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
     * @return ConstrainedDeleteQueryBuilder
     */
    public function and(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->state->checkEquals(self::SECOND_STATE)) {
            echo "WARNING: Method called under wrong calling order. WHERE clause MUST already be started." . PHP_EOL;
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
     * @return ConstrainedDeleteQueryBuilder
     */
    public function andNot(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->state->checkEquals(self::SECOND_STATE)) {
            echo "WARNING: Method called under wrong calling order. WHERE clause MUST already be started." . PHP_EOL;
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
     * @return ConstrainedDeleteQueryBuilder
     */
    public function andBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        if (!$this->state->checkEquals(self::SECOND_STATE)) {
            echo "WARNING: Method called under wrong calling order. WHERE clause MUST already be started." . PHP_EOL;
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
     * @return ConstrainedDeleteQueryBuilder
     */
    public function andNotBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        if (!$this->state->checkEquals(self::SECOND_STATE)) {
            echo "WARNING: Method called under wrong calling order. WHERE clause MUST already be started." . PHP_EOL;
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
     * @return ConstrainedDeleteQueryBuilder
     */
    public function or(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->state->checkEquals(self::SECOND_STATE)) {
            echo "WARNING: Method called under wrong calling order. WHERE clause MUST already be started." . PHP_EOL;
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
     * @return ConstrainedDeleteQueryBuilder
     */
    public function orNot(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->state->checkEquals(self::SECOND_STATE)) {
            echo "WARNING: Method called under wrong calling order. WHERE clause MUST already be started." . PHP_EOL;
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
     * @return ConstrainedDeleteQueryBuilder
     */
    public function orBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        if (!$this->state->checkEquals(self::SECOND_STATE)) {
            echo "WARNING: Method called under wrong calling order. WHERE clause MUST already be started." . PHP_EOL;
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
     * @return ConstrainedDeleteQueryBuilder
     */
    public function orNotBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        if (!$this->state->checkEquals(self::SECOND_STATE)) {
            echo "WARNING: Method called under wrong calling order. WHERE clause MUST already be started." . PHP_EOL;
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->orNotBetween($column, $left, $right);

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
