<?php

namespace Jayrods\QueryBuilder\Builders\Simple;

use Jayrods\QueryBuilder\Builders\Simple\SimpleQueryBuilder;
use Jayrods\QueryBuilder\Exceptions\RepeatedBinderNameException;

class InsertQueryBuilder extends SimpleQueryBuilder
{
    /**
     * Table name.
     *
     * @var string
     */
    private string $table = '';

    /**
     * Columns to be inserted.
     *
     * @var string
     */
    private string $columns = '';

    /**
     * Values to be inserted (as prepared statement mode).
     *
     * @var string
     */
    private string $values = '';

    /**
     * Start building INSERT INTO query.
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
     * Set column and respective binder name as value.
     *
     * @param string $column
     * @param ?string $binder
     *
     * @throws RepeatedBinderNameException
     *
     * @return InsertQueryBuilder
     */
    public function column(string $column, ?string $binder = null): self
    {
        $binder = $this->bindHandler->handle($binder ?? $column);

        $this->columns .= "$column, ";

        $this->values .= "$binder, ";

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
     * Resets build-related attributes and helpers to default values.
     *
     * @return void
     */
    protected function reset(): void
    {
        $this->bindHandler->reset();

        $this->table = $this->columns = $this->values = '';
    }
}
