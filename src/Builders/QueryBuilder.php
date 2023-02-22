<?php

namespace Jayrods\QueryBuilder\Builders;

use Jayrods\QueryBuilder\Builders\QueryBuilderInterface;

abstract class QueryBuilder implements QueryBuilderInterface
{
    /**
     * Last built query. If no query was built, return empty string
     *
     * @var string
     */
    protected string $query = '';

    /**
     * Return the built query and reset all attributes and helpers to default value.
     *
     * @return string The SQL query.
     */
    public function build(): string
    {
        $this->queryBuild();
        $this->reset();

        return $this->query;
    }

    /**
     * Build the query and set it to the query attribute.
     *
     * @return void
     */
    abstract protected function queryBuild(): void;

    /**
     * Resets build-related attributes and helpers to default values.
     *
     * @return void
     */
    abstract protected function reset(): void;

    /**
     * Return the last built query or empty string.
     *
     * @return string
     */
    public function query(): string
    {
        return $this->query;
    }
}
