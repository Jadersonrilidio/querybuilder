<?php

namespace Jayrods\QueryBuilder\Utils;

class StateMachine
{
    /**
     * @var int
     */
    private int $state = 0;

    /**
     * 
     */
    public function __construct(int $state = 0)
    {
        $this->state = $state;
    }

    /**
     * 
     */
    public function up(): void
    {
        $this->state++;
    }

    /**
     * 
     */
    public function down(): void
    {
        $this->state--;
    }

    /**
     * 
     */
    public function reset(): void
    {
        $this->state = 0;
    }

    /**
     * 
     */
    public function set(int $state): void
    {
        $this->state = $state;
    }

    /**
     * 
     */
    public function checkEquals(int ...$states): bool
    {
        return array_search($this->state, $states, true) !== false ? true : false;
    }
}
