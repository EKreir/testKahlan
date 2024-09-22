<?php

namespace Event;

class Emitter {

    private static $instance = null;
    /**
     * Tableau associatif des événements et de leurs callbacks
     * @var Listener[][]
     */
    private $listeners = [];

    /**
     * Permet de récupérer l'instance de l'Emitter (singleton)
     *
     * @return Emitter
     */

    public static function getInstance(): Emitter
    {
        if (!self::$instance) {
            self::$instance = new Emitter();
        }
        return self::$instance;
    }

    /**
     * Permet d'émettre un événement
     *
     * @param string $event nom de l'événement
     * @param mixed ...$args arguments à passer aux callbacks
     */

    public function emit(string $event, ...$args)
    {
        if ($this->hasListener($event)) {
            foreach ($this->listeners[$event] as $listener) {
                $listener->handle($args);
            }
        }
    }

    /**
     * Permet d'écouter un événement
     *
     * @param string $event nom de l'événement
     * @param callable $callable callback à exécuter
     * @param int $priority priorité du callback
     * @return Listener
     */

    public function on(string $event, callable $callable, int $priority = 0): Listener
    {
        if (!$this->hasListener($event)) {
            $this->listeners[$event] = [];
        }
        $listener = new Listener($callable, $priority);
        $this->listeners[$event][] = $listener;
        $this->sortListeners($event);
        return $listener;
    }

    private function hasListener(string $event): bool
    {
        return array_key_exists($event, $this->listeners);
    }

    private function sortListeners($event)
    {
        usort($this->listeners[$event], function ($a, $b): bool {
            return $a->priority < $b->priority;
        });
    }

}