<?php

namespace Jayrods\QueryBuilder\Builders\Simple;

use Jayrods\QueryBuilder\Builders\QueryBuilder;
use Jayrods\QueryBuilder\Utils\{BindParamHandler, Configuration};

abstract class SimpleQueryBuilder extends QueryBuilder
{
    /**
     * BindParamHandler instance.
     *
     * @var BindParamHandler
     */
    protected BindParamHandler $bindHandler;

    /**
     * Class constructor.
     *
     * @param Configuration $appConfig
     */
    public function __construct(Configuration $appConfig)
    {
        $this->bindHandler = new BindParamHandler($appConfig);
    }
}
