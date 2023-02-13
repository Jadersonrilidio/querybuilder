<?php

namespace Jayrods\QueryBuilder;

use Jayrods\QueryBuilder\QueryBuilder;
use Jayrods\QueryBuilder\Exception\InvalidOperatorException;

class SelectQueryBuilder extends QueryBuilder
{
    /**
     * Table Name.
     * 
     * @var string
     */
    private string $table;

    /**
     * Columns to be selected.
     * 
     * @var string
     */
    private string $columns = '';

    /**
     * InnerJoin-edited part of the query.
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
     * Limit number of rows in result.
     * 
     * @var string
     */
    private string $limit = '';

    /**
     * Start building a query to select from into aimed table.
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
     * Adds a column to be selected.
     * 
     * @param string $column
     * @param ?string $refTable If the column comes from a relationship, thus the table name must be inserted.
     * 
     * @return SelectQueryBuilder
     */
    public function column(string $column, ?string $refTable = null): self
    {
        $refTable = $refTable ?? $this->table;

        $this->columns .= "$refTable.$column, ";
        return $this;
    }

    /**
     * Adds a column with AS clause to be selected.
     * 
     * @param string $column
     * @param string $as
     * @param ?string $refTable If the column comes from a relationship, thus the table name must be inserted.
     * 
     * @return SelectQueryBuilder
     */
    public function columnAs(string $column, string $as, ?string $refTable = null): self
    {
        $refTable = $refTable ?? $this->table;

        $this->columns .= "$refTable.$column AS $as, ";
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
     * @return SelectQueryBuilder
     */
    public function where(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->validOperator($operator)) {
            throw new InvalidOperatorException('Invalid operator signal');
        }
        $binder = $binder ?? "$column";

        $this->conditions = "WHERE {$this->table}.$column $operator :$binder";
        return $this;
    }

    /**
     * Starts a WHERE IN clause.
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
     * Starts a WHERE NOT IN clause.
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
     * Starts a WHERE NOT clause.
     * 
     * @param string $column
     * @param string $operator
     * @param ?string $binder
     * 
     * @throws InvalidOperatorException
     * 
     * @return SelectQueryBuilder
     */
    public function whereNot(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->validOperator($operator)) {
            throw new InvalidOperatorException('Invalid operator signal');
        }

        $binder = $binder ?? "$column";

        $this->conditions = "WHERE NOT {$this->table}.$column $operator :$binder";
        return $this;
    }

    /**
     * Starts a WHERE BETWEEN clause.
     * 
     * @param string $column
     * @param ?string $left
     * @param ?string $right
     * 
     * @return SelectQueryBuilder
     */
    public function whereBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        $left = $left ?? "{$column}_left";
        $right = $right ?? "{$column}_right";

        $this->conditions = "WHERE {$this->table}.$column BETWEEN :$left AND :$right";
        return $this;
    }

    /**
     * Starts a WHERE NOT BETWEEN clause.
     * 
     * @param string $column
     * @param ?string $left
     * @param ?string $right
     * 
     * @return SelectQueryBuilder
     */
    public function whereNotBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        $left = $left ?? "{$column}_left";
        $right = $right ?? "{$column}_right";

        $this->conditions = "WHERE {$this->table}.$column NOT BETWEEN :$left AND :$right";
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
     * @return SelectQueryBuilder
     */
    public function and(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->validOperator($operator)) {
            throw new InvalidOperatorException('Invalid operator signal');
        }

        $binder = $binder ?? "$column";

        $this->conditions .= " AND {$this->table}.$column $operator :$binder";
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
     * @return SelectQueryBuilder
     */
    public function andNot(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->validOperator($operator)) {
            throw new InvalidOperatorException('Invalid operator signal');
        }

        $binder = $binder ?? "$column";

        $this->conditions .= " AND NOT {$this->table}.$column $operator :$binder";
        return $this;
    }

    /**
     * Adds an AND BETWEEN clause to conditions.
     * 
     * @param string $column
     * @param ?string $left
     * @param ?string $right
     * 
     * @return SelectQueryBuilder
     */
    public function andBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        $left = $left ?? "{$column}_left";
        $right = $right ?? "{$column}_right";

        $this->conditions .= " AND {$this->table}.$column BETWEEN :$left AND :$right";
        return $this;
    }

    /**
     * Adds an AND NOT BETWEEN clause to conditions.
     * 
     * @param string $column
     * @param ?string $left
     * @param ?string $right
     * 
     * @return SelectQueryBuilder
     */
    public function andNotBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        $left = $left ?? "{$column}_left";
        $right = $right ?? "{$column}_right";

        $this->conditions .= " AND {$this->table}.$column NOT BETWEEN :$left AND :$right";
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
     * @return SelectQueryBuilder
     */
    public function or(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->validOperator($operator)) {
            throw new InvalidOperatorException('Invalid operator signal');
        }

        $binder = $binder ?? "$column";

        $this->conditions .= " OR {$this->table}.$column $operator :$binder";
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
     * @return SelectQueryBuilder
     */
    public function orNot(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->validOperator($operator)) {
            throw new InvalidOperatorException('Invalid operator signal');
        }

        $binder = $binder ?? "$column";

        $this->conditions .= " OR NOT {$this->table}.$column $operator :$binder";
        return $this;
    }

    /**
     * Adds an OR BETWEEN clause to conditions.
     * 
     * @param string $column
     * @param ?string $left
     * @param ?string $right
     * 
     * @return SelectQueryBuilder
     */
    public function orBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        $left = $left ?? "{$column}_left";
        $right = $right ?? "{$column}_right";

        $this->conditions .= " OR {$this->table}.$column NOT BETWEEN :$left AND :$right";
        return $this;
    }

    /**
     * Adds an OR NOT BETWEEN clause to conditions.
     * 
     * @param string $column
     * @param ?string $left
     * @param ?string $right
     * 
     * @return SelectQueryBuilder
     */
    public function orNotBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        $left = $left ?? "{$column}_left";
        $right = $right ?? "{$column}_right";

        $this->conditions .= " OR {$this->table}.$column NOT BETWEEN :$left AND :$right";
        return $this;
    }

    /**
     * Set the LIMIT of results.
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
     * Set the ORDER BY clause.
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
     * Adds an INNER JOIN clause.
     * 
     * @param string $joinTable
     * @param string $columnTable
     * @param string $columnJoinTable
     * @param string $operator
     * 
     * @throws InvalidOperatorException
     * 
     * @return SelectQueryBuilder
     */
    public function innerJoin(string $joinTable, string $columnTable, string $columnJoinTable,  string $operator): self
    {
        if (!$this->validOperator($operator)) {
            throw new InvalidOperatorException('Invalid operator signal');
        }

        $this->innerJoin = "INNER JOIN $joinTable ON $joinTable.$columnJoinTable $operator {$this->table}.$columnTable";

        return $this;
    }

    // public function leftJoin(): self
    // {
    //     return $this;
    // }

    // public function rightJoin(): self
    // {
    //     return $this;
    // }

    // public function fullJoin(): self
    // {
    //     // SELECT columns FROM table_1 JOIN table_2 ON table_1_column_1 WHERE table_2_column_2;
    //     return $this;
    // }

    // public function groupBy(): self
    // {
    //     // SELECT columns FROM table_1 JOIN table_2 ON table_1_column_1 WHERE table_2_column_2;
    //     return $this;
    // }

    /**
     * Build the query and set it to the query attribute.
     * 
     * @return void
     */
    protected function queryBuild(): void
    {
        $this->columns = $this->columns !== '' ? rtrim($this->columns, ', ') : '*';

        $this->query = "SELECT {$this->columns} FROM {$this->table} {$this->innerJoin} {$this->conditions} {$this->orderBy} {$this->limit}";
        $this->query = trim($this->query);
    }

    /**
     * Resets build-related attributes to default values.
     * 
     * @return void
     */
    protected function reset(): void
    {
        unset($this->table);
        $this->columns = $this->innerJoin = $this->conditions = $this->orderBy = $this->limit = '';
    }

    /**
     * Checks whether the operator sign is valid or not.
     * 
     * @param string $operator
     * 
     * @return bool
     */
    private function validOperator(string $operator): bool
    {
        return in_array(
            strtoupper($operator),
            ['=', '<>', '>', '<', '>=', '<=', 'LIKE'],
            true
        );
    }
}
