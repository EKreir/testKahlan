<?php

namespace Event;

class Listener {

    /**
     *
     * @var callable
     */
    private $callback;
    /**
     *
     * @var int
     */
    public $priority;

    public function __construct(callable $callback, int $priority)
    {
        $this->callback = $callback;
        $this->priority = $priority;
    }

    public function handle(array $args)
    {
        return call_user_func_array($this->callback, $args);
    }

}