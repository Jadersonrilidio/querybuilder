<?php

namespace Jayrods\QueryBuilder\Exceptions;

use DomainException;
use Throwable;

class InvalidOperatorException extends DomainException
{
    /**
     * Class Constructor.
     *
     * @param string $operator
     * @param string $message
     * @param int $code
     * @param ?Throwable $previous
     *
     * @return void
     */
    public function __construct(
        string $operator,
        string $message = '',
        int $code = 0,
        ?Throwable $previous = null
    ) {
        if ($message === '') {
            $message = $this->editMessage($operator);
        }

        parent::__construct($message, $code, $previous);
    }

    /**
     * Edit and return exception message.
     *
     * @param string $operator
     *
     * @return string
     */
    private function editMessage(string $operator): string
    {
        return "Invalid operator '$operator'" . PHP_EOL;
    }
}
