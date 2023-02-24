<?php

namespace Jayrods\QueryBuilder\Builders\Constrained;

use Jayrods\QueryBuilder\Builders\QueryBuilderInterface;
use Jayrods\QueryBuilder\Utils\{
    ConstraintErrorHandler,
    MethodRecordHelper,
    StateMachine
};

abstract class ConstrainedQueryBuilder implements QueryBuilderInterface
{
    /**
     * StateMachine-related constant.
     *
     * @var int
     */
    protected const STATE_ZERO = 0;

    /**
     * StateMachine-related constant.
     *
     * @var int
     */
    protected const FIRST_STATE = 1;

    /**
     * StateMachine-related constant.
     *
     * @var int
     */
    protected const SECOND_STATE = 2;

    /**
     * StateMachine instance.
     *
     * @var StateMachine
     */
    protected StateMachine $state;

    /**
     * MethodRecordHelper instance.
     *
     * @var MethodRecordHelper
     */
    protected MethodRecordHelper $methodRercord;

    /**
     * ConstraintErrorHandler instance.
     *
     * @var ConstraintErrorHandler
     */
    protected ConstraintErrorHandler $errorHandler;

    /**
     * Class constructor.
     *
     * @param StateMachine $state
     * @param MethodRecordHelper $methodRercord
     * @param ConstraintErrorHandler $errorHandler
     *
     * @return void
     */
    public function __construct(
        StateMachine $state,
        MethodRecordHelper $methodRercord,
        ConstraintErrorHandler $errorHandler
    ) {
        $this->state = $state;
        $this->methodRercord = $methodRercord;
        $this->errorHandler = $errorHandler;
    }

    /**
     * Return array with BindParam names acresced by ':' notation.
     *
     * @return string[]
     */
    abstract public function getBindParams(): array;
}
