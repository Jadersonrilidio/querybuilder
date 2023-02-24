<?php

namespace Jayrods\QueryBuilder\Exceptions;

use DomainException;
use Throwable;

class WrongStateMethodCallException extends DomainException
{
    /**
     * Class Constructor.
     *
     * @param string $method
     * @param string $additionalMessage
     * @param string $message
     * @param int $code
     * @param ?Throwable $previous
     *
     * @return void
     */
    public function __construct(
        string $method,
        string $additionalMessage = '',
        string $message = '',
        int $code = 0,
        ?Throwable $previous = null
    ) {
        if ($message === '') {
            $message = $this->editMessage($method, $additionalMessage);
        }

        parent::__construct($message, $code, $previous);
    }

    /**
     * Edit and return exception message.
     *
     * @param string $method
     * @param string $additionalMessage
     *
     * @return string
     */
    private function editMessage(string $method, string $additionalMessage = ''): string
    {
        return "Method '$method' wrong calling order. $additionalMessage. " .
            "Ignoring '$method' method call." . PHP_EOL;
    }
}
