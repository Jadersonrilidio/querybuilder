<?php

namespace Jayrods\QueryBuilder\Traits;

trait MethodNameParser
{
    /**
     * Parse provided method's name from it's namespace and return plain method name.
     *
     * @param string $method It is strongly encouraged to use __METHOD__ magic constant as argument.
     *
     * @return string Plain method name.
     */
    protected function parseMethodName(string $method): string
    {
        $exploded = explode('::', $method);

        return array_pop($exploded);
    }
}
