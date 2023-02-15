<?php

namespace Jayrods\QueryBuilder\Builders\Simple;

use Jayrods\QueryBuilder\Exceptions\InvalidOperatorException;
use Jayrods\QueryBuilder\Builders\QueryBuilder;
use Jayrods\QueryBuilder\Traits\ValidateOperator;

class UpdateQueryBuilder extends QueryBuilder
{
    use ValidateOperator;

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
     * Conditions clauses.
     * 
     * @var string
     */
    private string $conditions = '';

    /**
     * Start building a query to select from into aimed table.
     * 
     * @param string $table
     * 
     * @return UpdateQueryBuilder
     */
    public function update(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    /**
     * Adds a column to be selected.
     * 
     * @param string $column
     * @param ?string $binder
     * 
     * @return UpdateQueryBuilder
     */
    public function column(string $column, ?string $binder = null): self
    {
        $binder = $binder ?? $column;

        $this->columns .= "$column = :$binder, ";
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
     * @return UpdateQueryBuilder
     */
    public function where(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->isValidOperator($operator)) {
            throw new InvalidOperatorException('Invalid operator signal');
        }
        $binder = $binder ?? "$column";

        $this->conditions = "WHERE $column $operator :$binder";
        return $this;
    }

    /**
     * Starts a WHERE IN clause.
     * 
     * @param string $column
     * @param string $subquery
     * 
     * @return UpdateQueryBuilder
     */
    public function whereIn(string $column, string $subquery): self
    {
        $this->conditions = "WHERE $column IN ($subquery)";
        return $this;
    }

    /**
     * Starts a WHERE NOT IN clause.
     * 
     * @param string $column
     * @param string $subquery
     * 
     * @return UpdateQueryBuilder
     */
    public function whereNotIn(string $column, string $subquery): self
    {
        $this->conditions = "WHERE $column NOT IN ($subquery)";
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
     * @return UpdateQueryBuilder
     */
    public function whereNot(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->isValidOperator($operator)) {
            throw new InvalidOperatorException('Invalid operator signal');
        }

        $binder = $binder ?? "$column";

        $this->conditions = "WHERE NOT $column $operator :$binder";
        return $this;
    }

    /**
     * Starts a WHERE BETWEEN clause.
     * 
     * @param string $column
     * @param ?string $left
     * @param ?string $right
     * 
     * @return UpdateQueryBuilder
     */
    public function whereBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        $left = $left ?? "{$column}_left";
        $right = $right ?? "{$column}_right";

        $this->conditions = "WHERE $column BETWEEN :$left AND :$right";
        return $this;
    }

    /**
     * Starts a WHERE NOT BETWEEN clause.
     * 
     * @param string $column
     * @param ?string $left
     * @param ?string $right
     * 
     * @return UpdateQueryBuilder
     */
    public function whereNotBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        $left = $left ?? "{$column}_left";
        $right = $right ?? "{$column}_right";

        $this->conditions = "WHERE $column NOT BETWEEN :$left AND :$right";
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
     * @return UpdateQueryBuilder
     */
    public function and(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->isValidOperator($operator)) {
            throw new InvalidOperatorException('Invalid operator signal');
        }

        $binder = $binder ?? "$column";

        $this->conditions .= " AND $column $operator :$binder";
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
     * @return UpdateQueryBuilder
     */
    public function andNot(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->isValidOperator($operator)) {
            throw new InvalidOperatorException('Invalid operator signal');
        }

        $binder = $binder ?? "$column";

        $this->conditions .= " AND NOT $column $operator :$binder";
        return $this;
    }

    /**
     * Adds an AND BETWEEN clause to conditions.
     * 
     * @param string $column
     * @param ?string $left
     * @param ?string $right
     * 
     * @return UpdateQueryBuilder
     */
    public function andBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        $left = $left ?? "{$column}_left";
        $right = $right ?? "{$column}_right";

        $this->conditions .= " AND $column BETWEEN :$left AND :$right";
        return $this;
    }

    /**
     * Adds an AND NOT BETWEEN clause to conditions.
     * 
     * @param string $column
     * @param ?string $left
     * @param ?string $right
     * 
     * @return UpdateQueryBuilder
     */
    public function andNotBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        $left = $left ?? "{$column}_left";
        $right = $right ?? "{$column}_right";

        $this->conditions .= " AND $column NOT BETWEEN :$left AND :$right";
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
     * @return UpdateQueryBuilder
     */
    public function or(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->isValidOperator($operator)) {
            throw new InvalidOperatorException('Invalid operator signal');
        }

        $binder = $binder ?? "$column";

        $this->conditions .= " OR $column $operator :$binder";
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
     * @return UpdateQueryBuilder
     */
    public function orNot(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->isValidOperator($operator)) {
            throw new InvalidOperatorException('Invalid operator signal');
        }

        $binder = $binder ?? "$column";

        $this->conditions .= " OR NOT $column $operator :$binder";
        return $this;
    }

    /**
     * Adds an OR BETWEEN clause to conditions.
     * 
     * @param string $column
     * @param ?string $left
     * @param ?string $right
     * 
     * @return UpdateQueryBuilder
     */
    public function orBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        $left = $left ?? "{$column}_left";
        $right = $right ?? "{$column}_right";

        $this->conditions .= " OR $column NOT BETWEEN :$left AND :$right";
        return $this;
    }

    /**
     * Adds an OR NOT BETWEEN clause to conditions.
     * 
     * @param string $column
     * @param ?string $left
     * @param ?string $right
     * 
     * @return UpdateQueryBuilder
     */
    public function orNotBetween(string $column, ?string $left = null, ?string $right = null): self
    {
        $left = $left ?? "{$column}_left";
        $right = $right ?? "{$column}_right";

        $this->conditions .= " OR $column NOT BETWEEN :$left AND :$right";
        return $this;
    }

    /**
     * Build the query and set it to the query attribute.
     * 
     * @return void
     */
    protected function queryBuild(): void
    {
        $this->columns = rtrim($this->columns, ', ');

        $this->query = "UPDATE {$this->table} SET {$this->columns} {$this->conditions}";
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
        $this->columns = $this->conditions = '';
    }
}
