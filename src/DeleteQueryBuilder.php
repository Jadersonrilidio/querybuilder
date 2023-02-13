<?php

namespace Jayrods\QueryBuilder;

use Jayrods\QueryBuilder\QueryBuilder;
use Jayrods\QueryBuilder\Exception\InvalidOperatorException;

class DeleteQueryBuilder extends QueryBuilder
{
    /**
     * Table Name.
     * 
     * @var string
     */
    private string $table;

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
     * @return SelectQueryBuilder
     */
    public function delete(string $table): self
    {
        $this->table = $table;
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

        $this->conditions = "WHERE $column $operator :$binder";
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
        $this->conditions = "WHERE $column IN ($subquery)";
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
     * @return SelectQueryBuilder
     */
    public function whereNot(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->validOperator($operator)) {
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
     * @return SelectQueryBuilder
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
     * @return SelectQueryBuilder
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
     * @return SelectQueryBuilder
     */
    public function and(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->validOperator($operator)) {
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
     * @return SelectQueryBuilder
     */
    public function andNot(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->validOperator($operator)) {
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
     * @return SelectQueryBuilder
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
     * @return SelectQueryBuilder
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
     * @return SelectQueryBuilder
     */
    public function or(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->validOperator($operator)) {
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
     * @return SelectQueryBuilder
     */
    public function orNot(string $column, string $operator, ?string $binder = null): self
    {
        if (!$this->validOperator($operator)) {
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
     * @return SelectQueryBuilder
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
     * @return SelectQueryBuilder
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
        $this->query = "DELETE FROM {$this->table} {$this->conditions}";
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
        $this->conditions = '';
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
