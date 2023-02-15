<?php

namespace Jayrods\QueryBuilder\Utils;

class MethodRecordHelper
{
    /**
     * @var int[]
     */
    private array $methodsCall = array();

    /**
     * @param string $method It is strongly encouraged to use __METHOD__ magic constant as argument.
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
     * @param string $method It is strongly encouraged to use __METHOD__ magic constant as argument.
     */
    public function methodCallAmount(string $method): int
    {
        $method = $this->parseMethodName($method);

        return $this->methodsCall[$method] ?? 0;
    }

    /**
     * @param string[] $method It is strongly encouraged to use __METHOD__ magic constant as argument.
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
     * @param string $method It is strongly encouraged to use __METHOD__ magic constant as argument.
     * 
     * @return int[]
     */
    public function methodsCall(): array
    {
        return $this->methodsCall;
    }

    /**
     * 
     */
    public function resetMethodsCall(): void
    {
        $this->methodsCall = array();
    }

    /**
     * 
     */
    private function parseMethodName(string $method): string
    {
        $exploded = explode('::', $method);

        return array_pop($exploded);
    }
}
