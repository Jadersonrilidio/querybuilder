<?php

namespace Jayrods\QueryBuilder\Builders\Constrained;

use Jayrods\QueryBuilder\Builders\Constrained\ConstrainedQueryBuilder;
use Jayrods\QueryBuilder\Builders\Simple\InsertQueryBuilder as SimpleInsertQueryBuilder;
use Jayrods\QueryBuilder\Exceptions\{
    RepeatedBinderNameException,
    WrongStateMethodCallException
};
use Jayrods\QueryBuilder\Utils\{
    ConstraintErrorHandler,
    MethodRecordHelper,
    StateMachine
};

class InsertQueryBuilder extends ConstrainedQueryBuilder
{
    /**
     * InsertQueryBuilder instance.
     *
     * @var SimpleInsertQueryBuilder
     */
    private SimpleInsertQueryBuilder $builder;

    /**
     * Class constructor.
     *
     * @param StateMachine $state
     * @param MethodRecordHelper $methodRercord
     * @param ConstraintErrorHandler $errorHandler
     * @param SimpleInsertQueryBuilder $builder
     *
     * @return void
     */
    public function __construct(
        StateMachine $state,
        MethodRecordHelper $methodRercord,
        ConstraintErrorHandler $errorHandler,
        SimpleInsertQueryBuilder $builder
    ) {
        parent::__construct($state, $methodRercord, $errorHandler);

        $this->builder = $builder;
    }

    /**
     * Start building INSERT INTO query.
     *
     * @param string $table
     *
     * @throws WrongStateMethodCallException
     *
     * @return InsertQueryBuilder
     */
    public function insertInto(string $table): self
    {
        if (!$this->state->checkEquals(self::STATE_ZERO)) {
            $this->errorHandler->wrongStateMethodCall(__METHOD__, 'Building proccess already started');
            return $this;
        }

        $this->state->up();

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->insertInto($table);

        return $this;
    }

    /**
     * Set column and respective binder name as value.
     *
     * @param string $column
     * @param ?string $binder
     *
     * @throws RepeatedBinderNameException|WrongStateMethodCallException
     *
     * @return InsertQueryBuilder
     */
    public function column(string $column, ?string $binder = null): self
    {
        if (!$this->state->checkEquals(self::FIRST_STATE)) {
            $this->errorHandler->wrongStateMethodCall(__METHOD__);
            return $this;
        }

        $this->methodRercord->registerMethodCall(__METHOD__);

        $this->builder->column($column, $binder);

        return $this;
    }

    /**
     * Return the built query and reset all attributes and helpers to default value.
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

    /**
     * Return array with BindParam names acresced by ':' notation.
     *
     * @return string[]
     */
    public function getBindParams(): array
    {
        return $this->builder->getBindParams();
    }
}
