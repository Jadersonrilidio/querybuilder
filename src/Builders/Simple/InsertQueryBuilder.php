<?php

namespace Jayrods\QueryBuilder\Builders\Simple;

use Jayrods\QueryBuilder\Builders\QueryBuilder;

class InsertQueryBuilder extends QueryBuilder
{
    /**
     * Table name.
     * 
     * @var string
     */
    private string $table;

    /**
     * Columns to be inserted.
     * 
     * @var string
     */
    private string $columns = '';

    /**
     * Values to be inserted as prepared statement.
     * 
     * @var string
     */
    private string $values = '';

    /**
     * Start building a query to insert into aimed table.
     * 
     * @param string $table
     * 
     * @return InsertQueryBuilder
     */
    public function insertInto(string $table): self
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Set colum and value as prepared statement to insert query.
     * 
     * @param string $column
     * 
     * @return InsertQueryBuilder
     */
    public function column(string $column, ?string $binder = null): self
    {
        $binder = $binder ?? $column;

        $this->columns .= "$column, ";

        $this->values .= ":$binder, ";

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
        $this->values = rtrim($this->values, ', ');

        $this->query = "INSERT INTO {$this->table} ({$this->columns}) VALUES ({$this->values})";
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
        $this->columns = $this->values = '';
    }
}
