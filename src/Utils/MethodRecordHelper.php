<?php

namespace Jayrods\QueryBuilder\Utils;

use Jayrods\QueryBuilder\Traits\MethodNameParser;

class MethodRecordHelper
{
    use MethodNameParser;

    /**
     * Array containing called methods' names as key and called times as value.
     *
     * @var int[]
     */
    private array $methodsCall = array();

    /**
     * Register a method call.
     *
     * @param string $method It is strongly encouraged to use __METHOD__ magic constant as argument.
     *
     * @return void
     */
    public function registerMethodCall(string $method): void
    {
        $method = $this->parseMethodName($method);

        if (isset($this->methodsCall[$method])) {
            $this->methodsCall[$method]++;
        } else {
            $this->methodsCall[$method] = 1;
        }
    }

    /**
     * Check whether a list of methods' names where called at least once or not.
     *
     * @param string $methods It is strongly encouraged to use __METHOD__ magic constant as argument.
     *
     * @return bool
     */
    public function methodCalledOnce(string ...$methods): bool
    {
        foreach ($methods as $method) {
            $method = $this->parseMethodName($method);

            if (isset($this->methodsCall[$method])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Return associative array of called methods with names as key and called times as value.
     *
     * @return int[]
     */
    public function methodsCall(): array
    {
        return $this->methodsCall;
    }

    /**
     * Reset list of called methods to empty.
     *
     * @return void
     */
    public function resetMethodsCall(): void
    {
        $this->methodsCall = array();
    }
}
