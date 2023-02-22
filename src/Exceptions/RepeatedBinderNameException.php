<?php

namespace Jayrods\QueryBuilder\Exceptions;

use DomainException;
use Throwable;

class RepeatedBinderNameException extends DomainException
{
    /**
     * Class Constructor.
     *
     * @param string $binder
     * @param int $count
     * @param string $message
     * @param int $code
     * @param ?Throwable $previous
     *
     * @return void
     */
    public function __construct(
        string $binder,
        int $count,
        string $message = '',
        int $code = 0,
        ?Throwable $previous = null
    ) {
        if ($message === '') {
            $message = $this->editMessage($binder, $count);
        }

        parent::__construct($message, $code, $previous);
    }

    /**
     * Edit and return exception message.
     *
     * @param string $binder
     * @param int $count
     *
     * @return string
     */
    private function editMessage(string $binder, int $count): string
    {
        return "BindParam ':$binder' repeated $count times." . PHP_EOL;
    }
}
