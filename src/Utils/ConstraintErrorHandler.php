<?php

namespace Jayrods\QueryBuilder\Utils;

use Jayrods\QueryBuilder\Exceptions\{
    DuplicatedMethodCallException,
    WrongStateMethodCallException
};
use Jayrods\QueryBuilder\Traits\MethodNameParser;

class ConstraintErrorHandler
{
    use MethodNameParser;

    /**
     * Enable constrained mode to throw an exception on fail.
     *
     * @var bool
     */
    private bool $failMode;

    /**
     * Enable constrained mode to echo exception message information on fail.
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
        $this->failMode = $appConfig->failOnWrongMethodCall();
        $this->echoWarningsMode = $appConfig->echoWarningsOnWrongMethodCall();
    }

    /**
     * Throw WrongStateMethodCallException or echo exception's message informations regarding of configuration setting.
     *
     * @param string $method
     * @param string $additionalMessage
     *
     * @return void
     */
    public function wrongStateMethodCall(string $method, string $additionalMessage = ''): void
    {
        $method = $this->parseMethodName($method);

        if ($this->echoWarningsMode) {
            echo (new WrongStateMethodCallException($method, $additionalMessage))->getMessage();
        }

        if ($this->failMode) {
            throw new WrongStateMethodCallException($method, $additionalMessage);
        }
    }

    /**
     * Throw DuplicatedMethodCallException or echo exception's message informations regarding of configuration setting.
     *
     * @param string $method
     * @param string $additionalMessage
     *
     * @return void
     */
    public function duplicatedMethodCall(string $method, string $additionalMessage = ''): void
    {
        $method = $this->parseMethodName($method);

        if ($this->echoWarningsMode) {
            echo (new DuplicatedMethodCallException($method, $additionalMessage))->getMessage();
        }

        if ($this->failMode) {
            throw new DuplicatedMethodCallException($method, $additionalMessage);
        }
    }
}
