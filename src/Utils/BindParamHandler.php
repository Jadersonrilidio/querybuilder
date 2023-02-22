<?php

namespace Jayrods\QueryBuilder\Utils;

use Jayrods\QueryBuilder\Exceptions\RepeatedBinderNameException;
use Jayrods\QueryBuilder\Utils\{BindErrorHandler, Configuration};

class BindParamHandler
{
    /**
     * Register used binders and amount of times used.
     *
     * @var int[]
     */
    private array $binders = array();

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
     *
     * @return void
     */
    public function __construct(Configuration $appConfig)
    {
        $this->namedBindParamMode = $appConfig->namedBindParamMode();
        $this->errorHandler = new BindErrorHandler($appConfig);
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
        if (array_key_exists($binder, $this->binders)) {
            $this->binders[$binder]++;
            $this->errorHandler->repeatedBinderName($binder, $this->binders[$binder]);
        } else {
            $this->binders[$binder] = 1;
        }
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
}
