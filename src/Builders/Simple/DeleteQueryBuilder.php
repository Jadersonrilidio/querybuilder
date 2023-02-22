<?php

namespace Jayrods\QueryBuilder\Builders\Simple;

use Jayrods\QueryBuilder\Exceptions\{InvalidOperatorException, RepeatedBinderNameException};
use Jayrods\QueryBuilder\Builders\Simple\SimpleQueryBuilder;
use Jayrods\QueryBuilder\Traits\ValidateOperator;

class DeleteQueryBuilder extends SimpleQueryBuilder
{
    use ValidateOperator;

    /**
     * Table Name.
     *
     * @var string
     */
    private string $table = '';

    /**
     * Conditions clauses.
     *
     * @var string
     */
    private string $conditions = '';

    /**
     * Start building DELETE query.
     *
     * @param string $table
     *
     * @return DeleteQueryBuilder
     */
    public function delete(string $table): self
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Start building WHERE clause.
     *
     * @param string $column
     * @param string $operator
     * @param ?string $binder
     *
     * @throws InvalidOperatorException|RepeatedBinderNameException
     *
     * @return DeleteQueryBuilder
     */
    public function where(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->isValidOperator($operator)) {
            throw new InvalidOperatorException($operator);
        }

        $binder = $this->bindHandler->handle($binder ?? $column);

        $this->conditions = "WHERE $column $operator $binder";

        return $this;
    }

    /**
     * Start WHERE IN clause.
     *
     * @param string $column
     * @param string $subquery
     *
     * @return DeleteQueryBuilder
     */
    public function whereIn(string $column, string $subquery): self
    {
        $this->conditions = "WHERE $column IN ($subquery)";

        return $this;
    }

    /**
     * Start WHERE NOT IN clause.
     *
     * @param string $column
     * @param string $subquery
     *
     * @return DeleteQueryBuilder
     */
    public function whereNotIn(string $column, string $subquery): self
    {
        $this->conditions = "WHERE $column NOT IN ($subquery)";

        return $this;
    }

    /**
     * Start WHERE NOT clause.
     *
     * @param string $column
     * @param string $operator
     * @param ?string $binder
     *
     * @throws InvalidOperatorException|RepeatedBinderNameException
     *
     * @return DeleteQueryBuilder
     */
    public function whereNot(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->isValidOperator($operator)) {
            throw new InvalidOperatorException($operator);
        }

        $binder = $this->bindHandler->handle($binder ?? $column);

        $this->conditions = "WHERE NOT $column $operator $binder";

        return $this;
    }

    /**
     * Start WHERE BETWEEN clause.
     *
     * @param string $column
     * @param ?string $left
     * @param ?string $right
     *
     * @throws RepeatedBinderNameException
     *
     * @return DeleteQueryBuilder
     */
    public function whereBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        $left = $this->bindHandler->handle($left ?? "{$column}_left");
        $right = $this->bindHandler->handle($right ?? "{$column}_right");

        $this->conditions = "WHERE $column BETWEEN $left AND $right";

        return $this;
    }

    /**
     * Start WHERE NOT BETWEEN clause.
     *
     * @param string $column
     * @param ?string $left
     * @param ?string $right
     *
     * @throws RepeatedBinderNameException
     *
     * @return DeleteQueryBuilder
     */
    public function whereNotBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        $left = $this->bindHandler->handle($left ?? "{$column}_left");
        $right = $this->bindHandler->handle($right ?? "{$column}_right");

        $this->conditions = "WHERE $column NOT BETWEEN $left AND $right";

        return $this;
    }

    /**
     * Add AND clause to conditions.
     *
     * @param string $column
     * @param string $operator
     * @param ?string $binder
     *
     * @throws InvalidOperatorException|RepeatedBinderNameException
     *
     * @return DeleteQueryBuilder
     */
    public function and(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->isValidOperator($operator)) {
            throw new InvalidOperatorException($operator);
        }

        $binder = $this->bindHandler->handle($binder ?? $column);

        $this->conditions .= " AND $column $operator $binder";

        return $this;
    }

    /**
     * Add AND NOT clause to conditions.
     *
     * @param string $column
     * @param string $operator
     * @param ?string $binder
     *
     * @throws InvalidOperatorException|RepeatedBinderNameException
     *
     * @return DeleteQueryBuilder
     */
    public function andNot(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->isValidOperator($operator)) {
            throw new InvalidOperatorException($operator);
        }

        $binder = $this->bindHandler->handle($binder ?? $column);

        $this->conditions .= " AND NOT $column $operator $binder";

        return $this;
    }

    /**
     * Add AND BETWEEN clause to conditions.
     *
     * @param string $column
     * @param ?string $left
     * @param ?string $right
     *
     * @throws RepeatedBinderNameException
     *
     * @return DeleteQueryBuilder
     */
    public function andBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        $left = $this->bindHandler->handle($left ?? "{$column}_left");
        $right = $this->bindHandler->handle($right ?? "{$column}_right");

        $this->conditions .= " AND $column BETWEEN $left AND $right";

        return $this;
    }

    /**
     * Add AND NOT BETWEEN clause to conditions.
     *
     * @param string $column
     * @param ?string $left
     * @param ?string $right
     *
     * @throws RepeatedBinderNameException
     *
     * @return DeleteQueryBuilder
     */
    public function andNotBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        $left = $this->bindHandler->handle($left ?? "{$column}_left");
        $right = $this->bindHandler->handle($right ?? "{$column}_right");

        $this->conditions .= " AND $column NOT BETWEEN $left AND $right";

        return $this;
    }

    /**
     * Add OR clause to conditions.
     *
     * @param string $column
     * @param string $operator
     * @param ?string $binder
     *
     * @throws InvalidOperatorException|RepeatedBinderNameException
     *
     * @return DeleteQueryBuilder
     */
    public function or(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->isValidOperator($operator)) {
            throw new InvalidOperatorException($operator);
        }

        $binder = $this->bindHandler->handle($binder ?? $column);

        $this->conditions .= " OR $column $operator $binder";

        return $this;
    }

    /**
     * Add OR NOT clause to conditions.
     *
     * @param string $column
     * @param string $operator
     * @param ?string $binder
     *
     * @throws InvalidOperatorException|RepeatedBinderNameException
     *
     * @return DeleteQueryBuilder
     */
    public function orNot(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->isValidOperator($operator)) {
            throw new InvalidOperatorException($operator);
        }

        $binder = $this->bindHandler->handle($binder ?? $column);

        $this->conditions .= " OR NOT $column $operator $binder";

        return $this;
    }

    /**
     * Add OR BETWEEN clause to conditions.
     *
     * @param string $column
     * @param ?string $left
     * @param ?string $right
     *
     * @throws RepeatedBinderNameException
     *
     * @return DeleteQueryBuilder
     */
    public function orBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        $left = $this->bindHandler->handle($left ?? "{$column}_left");
        $right = $this->bindHandler->handle($right ?? "{$column}_right");

        $this->conditions .= " OR $column NOT BETWEEN $left AND $right";

        return $this;
    }

    /**
     * Add OR NOT BETWEEN clause to conditions.
     *
     * @param string $column
     * @param ?string $left
     * @param ?string $right
     *
     * @throws RepeatedBinderNameException
     *
     * @return DeleteQueryBuilder
     */
    public function orNotBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        $left = $this->bindHandler->handle($left ?? "{$column}_left");
        $right = $this->bindHandler->handle($right ?? "{$column}_right");

        $this->conditions .= " OR $column NOT BETWEEN $left AND $right";

        return $this;
    }

    /**
     * Build the query and set it to the query attribute.
     *
     * @return void
     */
    protected function queryBuild(): void
    {
        $this->query = "DELETE FROM {$this->table} {$this->conditions}";
        $this->query = trim($this->query);
    }

    /**
     * Resets build-related attributes and helpers to default values.
     *
     * @return void
     */
    protected function reset(): void
    {
        $this->bindHandler->reset();

        $this->table = $this->conditions = '';
    }
}
