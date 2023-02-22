<?php

namespace Jayrods\QueryBuilder\Builders\Constrained;

use Jayrods\QueryBuilder\Builders\QueryBuilderInterface;
use Jayrods\QueryBuilder\Utils\{
    Configuration,
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
     * @param Configuration $appConfig
     *
     * @return void
     */
    public function __construct(Configuration $appConfig)
    {
        $this->state = new StateMachine();
        $this->methodRercord = new MethodRecordHelper();
        $this->errorHandler = new ConstraintErrorHandler($appConfig);
    }
}
