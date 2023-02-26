<?php

namespace Jayrods\QueryBuilder\Utils;

use Jayrods\QueryBuilder\Exceptions\RepeatedBinderNameException;
use Jayrods\QueryBuilder\Utils\Configuration;

class BindErrorHandler
{
    /**
     * Enable to throw an exception on fail.
     *
     * @var bool
     */
    private bool $failMode;

    /**
     * Enable to echo exception message information on fail.
     *
     * @var bool
     */
    private bool $echoWarningsMode;

    /**
     * Class constructor.
     *
     * @param Configuration $appConfig
     *
     * @return void
     */
    public function __construct(Configuration $appConfig)
    {
        $this->failMode = $appConfig->parameterizedModeFailOnError();
        $this->echoWarningsMode = $appConfig->parameterizedModeFailOnError();
    }

    /**
     * Throw RepeatedBinderNameException or echo exception's message informations regarding of configuration setting.
     *
     * @param string $binder
     * @param int $count
     *
     * @throws RepeatedBinderNameException
     *
     * @return void
     */
    public function repeatedBinderName(string $binder, int $count): void
    {
        if ($this->echoWarningsMode) {
            echo (new RepeatedBinderNameException($binder, $count))->getMessage();
        }

        if ($this->failMode) {
            throw new RepeatedBinderNameException($binder, $count);
        }
    }
}
