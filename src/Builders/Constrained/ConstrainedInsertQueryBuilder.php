<?php

namespace Jayrods\QueryBuilder\Builders\Constrained;

use Jayrods\QueryBuilder\Builders\QueryBuilderInterface;
use Jayrods\QueryBuilder\Builders\Simple\InsertQueryBuilder;
use Jayrods\QueryBuilder\Utils\MethodRecordHelper;
use Jayrods\QueryBuilder\Utils\StateMachine;

class ConstrainedInsertQueryBuilder implements QueryBuilderInterface
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
     * InsertQueryBuilder instance.
     * 
     * @var InsertQueryBuilder
     */
    private InsertQueryBuilder $builder;

    /**
     * Class constructor.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->state = new StateMachine;
        $this->methodRercord = new MethodRecordHelper;
        $this->builder = new InsertQueryBuilder;
    }

    /**
     * Start building a query to select from into aimed table.
     * 
     * @param string $table
     * 
     * @return ConstrainedInsertQueryBuilder
     */
    public function insertInto(string $table): self
    {
        if (!$this->state->checkEquals(self::STATE_ZERO)) {
            echo "WARNING: Method called under wrong calling order. Machine already started." . PHP_EOL;
            return $this;
        }

        $this->state->up();

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->insertInto($table);

        return $this;
    }

    /**
     * Adds a column to be selected.
     * 
     * @param string $column
     * @param ?string $binder
     * 
     * @return ConstrainedInsertQueryBuilder
     */
    public function column(string $column, ?string $binder = null): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE)) {
            echo "WARNING: Method called under wrong calling order." . PHP_EOL;
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->column($column, $binder);

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
