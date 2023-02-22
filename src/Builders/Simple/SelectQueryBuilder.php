<?php

namespace Jayrods\QueryBuilder\Builders\Simple;

use Jayrods\QueryBuilder\Exceptions\{InvalidOperatorException, RepeatedBinderNameException};
use Jayrods\QueryBuilder\Builders\Simple\SimpleQueryBuilder;
use Jayrods\QueryBuilder\Traits\ValidateOperator;

class SelectQueryBuilder extends SimpleQueryBuilder
{
    use ValidateOperator;

    /**
     * Table Name.
     *
     * @var string
     */
    private string $table = '';

    /**
     * Columns to be selected.
     *
     * @var string
     */
    private string $columns = '';

    /**
     * InnerJoin statements.
     *
     * @var string
     */
    private string $innerJoin = '';

    /**
     * Conditions clauses.
     *
     * @var string
     */
    private string $conditions = '';

    /**
     * Sorting order.
     *
     * @var string
     */
    private string $orderBy = '';

    /**
     * Limit clause.
     *
     * @var string
     */
    private string $limit = '';

    /**
     * Start building SELECT FROM query.
     *
     * @param string $table
     *
     * @return SelectQueryBuilder
     */
    public function selectFrom(string $table): self
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Add column to be selected.
     *
     * @param string $column
     * @param ?string $refTable If the column comes from a relationship, thus the table name must be inserted.
     *
     * @return SelectQueryBuilder
     */
    public function column(string $column, ?string $refTable = null): self
    {
        $refTable ??= $this->table;

        $this->columns .= "$refTable.$column, ";

        return $this;
    }

    /**
     * Add column with AS clause to be selected.
     *
     * @param string $column
     * @param string $as
     * @param ?string $refTable If the column comes from a relationship, thus the table name must be inserted.
     *
     * @return SelectQueryBuilder
     */
    public function columnAs(string $column, string $as, ?string $refTable = null): self
    {
        $refTable ??= $this->table;

        $this->columns .= "$refTable.$column AS $as, ";

        return $this;
    }

    /**
     * Start WHERE clause.
     *
     * @param string $column
     * @param string $operator
     * @param ?string $binder
     *
     * @throws InvalidOperatorException|RepeatedBinderNameException
     *
     * @return SelectQueryBuilder
     */
    public function where(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->isValidOperator($operator)) {
            throw new InvalidOperatorException($operator);
        }

        $binder = $this->bindHandler->handle($binder ?? $column);

        $this->conditions = "WHERE {$this->table}.$column $operator $binder";

        return $this;
    }

    /**
     * Start WHERE IN clause.
     *
     * @param string $column
     * @param string $subquery
     *
     * @return SelectQueryBuilder
     */
    public function whereIn(string $column, string $subquery): self
    {
        $this->conditions = "WHERE {$this->table}.$column IN ($subquery)";

        return $this;
    }

    /**
     * Start WHERE NOT IN clause.
     *
     * @param string $column
     * @param string $subquery
     *
     * @return SelectQueryBuilder
     */
    public function whereNotIn(string $column, string $subquery): self
    {
        $this->conditions = "WHERE {$this->table}.$column NOT IN ($subquery)";

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
     * @return SelectQueryBuilder
     */
    public function whereNot(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->isValidOperator($operator)) {
            throw new InvalidOperatorException($operator);
        }

        $binder = $this->bindHandler->handle($binder ?? $column);

        $this->conditions = "WHERE NOT {$this->table}.$column $operator $binder";

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
     * @return SelectQueryBuilder
     */
    public function whereBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        $left = $this->bindHandler->handle($left ?? "{$column}_left");
        $right = $this->bindHandler->handle($right ?? "{$column}_right");

        $this->conditions = "WHERE {$this->table}.$column BETWEEN $left AND $right";
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
     * @return SelectQueryBuilder
     */
    public function whereNotBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        $left = $this->bindHandler->handle($left ?? "{$column}_left");
        $right = $this->bindHandler->handle($right ?? "{$column}_right");

        $this->conditions = "WHERE {$this->table}.$column NOT BETWEEN $left AND $right";

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
     * @return SelectQueryBuilder
     */
    public function and(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->isValidOperator($operator)) {
            throw new InvalidOperatorException($operator);
        }

        $binder = $this->bindHandler->handle($binder ?? $column);

        $this->conditions .= " AND {$this->table}.$column $operator $binder";
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
     * @return SelectQueryBuilder
     */
    public function andNot(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->isValidOperator($operator)) {
            throw new InvalidOperatorException($operator);
        }

        $binder = $this->bindHandler->handle($binder ?? $column);

        $this->conditions .= " AND NOT {$this->table}.$column $operator $binder";
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
     * @return SelectQueryBuilder
     */
    public function andBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        $left = $this->bindHandler->handle($left ?? "{$column}_left");
        $right = $this->bindHandler->handle($right ?? "{$column}_right");

        $this->conditions .= " AND {$this->table}.$column BETWEEN $left AND $right";

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
     * @return SelectQueryBuilder
     */
    public function andNotBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        $left = $this->bindHandler->handle($left ?? "{$column}_left");
        $right = $this->bindHandler->handle($right ?? "{$column}_right");

        $this->conditions .= " AND {$this->table}.$column NOT BETWEEN $left AND $right";

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
     * @return SelectQueryBuilder
     */
    public function or(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->isValidOperator($operator)) {
            throw new InvalidOperatorException($operator);
        }

        $binder = $this->bindHandler->handle($binder ?? $column);

        $this->conditions .= " OR {$this->table}.$column $operator $binder";
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
     * @return SelectQueryBuilder
     */
    public function orNot(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->isValidOperator($operator)) {
            throw new InvalidOperatorException($operator);
        }

        $binder = $this->bindHandler->handle($binder ?? $column);

        $this->conditions .= " OR NOT {$this->table}.$column $operator $binder";
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
     * @return SelectQueryBuilder
     */
    public function orBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        $left = $this->bindHandler->handle($left ?? "{$column}_left");
        $right = $this->bindHandler->handle($right ?? "{$column}_right");

        $this->conditions .= " OR {$this->table}.$column BETWEEN $left AND $right";

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
     * @return SelectQueryBuilder
     */
    public function orNotBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        $left = $this->bindHandler->handle($left ?? "{$column}_left");
        $right = $this->bindHandler->handle($right ?? "{$column}_right");

        $this->conditions .= " OR {$this->table}.$column NOT BETWEEN $left AND $right";

        return $this;
    }

    /**
     * Add LIMIT clause.
     *
     * @param int $limit
     *
     * @return SelectQueryBuilder
     */
    public function limit(int $limit): self
    {
        $this->limit = "LIMIT $limit";

        return $this;
    }

    /**
     * Add ORDER BY clause.
     *
     * @param string $column
     *
     * @return SelectQueryBuilder
     */
    public function orderBy(string $column): self
    {
        $this->orderBy = "ORDER BY {$this->table}.$column";

        return $this;
    }

    /**
     * Sort the result order ascending.
     *
     * @return SelectQueryBuilder
     */
    public function asc(): self
    {
        $this->orderBy = "{$this->orderBy} ASC";

        return $this;
    }

    /**
     * Sort the result order descending.
     *
     * @return SelectQueryBuilder
     */
    public function desc(): self
    {
        $this->orderBy = "{$this->orderBy} DESC";

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
     * @throws InvalidOperatorException
     *
     * @return SelectQueryBuilder
     */
    public function innerJoin(string $joinTable, string $columnTable, string $operator, string $columnJoinTable): self
    {
        if (!$this->isValidOperator($operator)) {
            throw new InvalidOperatorException($operator);
        }

        $this->innerJoin = "INNER JOIN $joinTable ON {$this->table}.$columnTable $operator $joinTable.$columnJoinTable";

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
     * @throws InvalidOperatorException
     *
     * @return SelectQueryBuilder
     */
    public function leftJoin(string $joinTable, string $columnTable, string $operator, string $columnJoinTable): self
    {
        if (!$this->isValidOperator($operator)) {
            throw new InvalidOperatorException($operator);
        }

        $this->innerJoin = "LEFT JOIN $joinTable ON {$this->table}.$columnTable $operator $joinTable.$columnJoinTable";

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
     * @throws InvalidOperatorException
     *
     * @return SelectQueryBuilder
     */
    public function rightJoin(string $joinTable, string $columnTable, string $operator, string $columnJoinTable): self
    {
        if (!$this->isValidOperator($operator)) {
            throw new InvalidOperatorException($operator);
        }

        $this->innerJoin = "RIGHT JOIN $joinTable ON {$this->table}.$columnTable $operator $joinTable.$columnJoinTable";

        return $this;
    }

    /**
     * Build the query and set it to the query attribute.
     *
     * @return void
     */
    protected function queryBuild(): void
    {
        $this->columns = $this->columns !== '' ? rtrim($this->columns, ', ') : '*';

        $this->query = "SELECT {$this->columns} " .
            "FROM {$this->table} {$this->innerJoin} {$this->conditions} {$this->orderBy} {$this->limit}";

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

        $this->table = $this->columns = $this->innerJoin = $this->conditions = $this->orderBy = $this->limit = '';
    }
}
