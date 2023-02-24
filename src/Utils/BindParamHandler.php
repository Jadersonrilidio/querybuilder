<?php

namespace Jayrods\QueryBuilder\Utils;

use Jayrods\QueryBuilder\Exceptions\RepeatedBinderNameException;
use Jayrods\QueryBuilder\Utils\{BindErrorHandler, Configuration};

class BindParamHandler
{
    /**
     * Associative array containing used binders' names as key and amount of times used as value.
     *
     * @var int[]
     */
    private array $binders = array();

    /**
     * Array containing used binders' names acresced by ':' notation.
     *
     * @var string[]
     */
    private array $bindersList = array();

    /**
     * Enable named BindParam if true or question mark if false.
     *
     * @var bool
     */
    private bool $namedBindParamMode;

    /**
     * BindErrorHandler instance.
     *
     * @var BindErrorHandler
     */
    private BindErrorHandler $errorHandler;

    /**
     * Class constructor.
     *
     * @param Configuration $appConfig
     * @param BindErrorHandler $errorHandler
     *
     * @return void
     */
    public function __construct(Configuration $appConfig, BindErrorHandler $errorHandler)
    {
        $this->namedBindParamMode = $appConfig->namedBindParamMode();
        $this->errorHandler = $errorHandler;
    }

    /**
     * Return the BindParam name to be used for a prepared statement.
     *
     * @param string $binder
     *
     * @throws RepeatedBinderNameException
     *
     * @return string BindParam name
     */
    public function handle(string $binder): string
    {
        if (!$this->namedBindParamMode) {
            return '?';
        }

        $this->register($binder);

        return ":$binder";
    }

    /**
     * Register a binder and the amount of times it is used.
     *
     * @param string $binder
     *
     * @throws RepeatedBinderNameException
     *
     * @return void
     */
    private function register(string $binder): void
    {
        if (empty($this->binders)) {
            $this->bindersList = array();
        }

        if (array_key_exists($binder, $this->binders)) {
            $this->binders[$binder]++;
            $this->errorHandler->repeatedBinderName($binder, $this->binders[$binder]);
        } else {
            $this->binders[$binder] = 1;
        }

        $this->bindersList[] = ":$binder";
    }

    /**
     * Reset the registered binders list to empty.
     *
     * @return void
     */
    public function reset(): void
    {
        $this->binders = array();
    }

    /**
     * Return array with BindParam names acresced by ':' notation.
     *
     * @return string[]
     */
    public function getBindParams(): array
    {
        return $this->bindersList;
    }
}
