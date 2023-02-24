<?php

namespace Jayrods\QueryBuilder\Builders\Simple;

use Jayrods\QueryBuilder\Builders\QueryBuilder;
use Jayrods\QueryBuilder\Utils\BindParamHandler;

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
     * @param BindParamHandler $bindHandler
     */
    public function __construct(BindParamHandler $bindHandler)
    {
        $this->bindHandler = $bindHandler;
    }

    /**
     * Return array with BindParam names acresced by ':' notation.
     *
     * @return string[]
     */
    public function getBindParams(): array
    {
        return $this->bindHandler->getBindParams();
    }
}
