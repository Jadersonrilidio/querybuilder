<?php

namespace Jayrods\QueryBuilder\Utils;

class StateMachine
{
    /**
     * Current state.
     *
     * @var int
     */
    private int $state = 0;

    /**
     * Increase state value by one.
     *
     * @return void
     */
    public function up(): void
    {
        $this->state++;
    }

    /**
     * Reset state value to zero.
     *
     * @return void
     */
    public function reset(): void
    {
        $this->state = 0;
    }

    /**
     * Check whether a list of state values matches with current state.
     *
     * @param int $states
     *
     * @return bool
     */
    public function checkEquals(int ...$states): bool
    {
        return array_search($this->state, $states, true) !== false ? true : false;
    }
}
