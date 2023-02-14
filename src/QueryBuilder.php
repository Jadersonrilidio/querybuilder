<?php

namespace Jayrods\QueryBuilder;

abstract class QueryBuilder
{
    /**
     * Last built query. If no query was built, return empty string;
     * 
     * @var string
     */
    protected string $query = '';

    /**
     * Return the built query and reset the paratemers to default value.
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
     * Resets build-related attributes to default values.
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
