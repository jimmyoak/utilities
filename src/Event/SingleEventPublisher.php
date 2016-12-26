<?php

namespace JimmyOak\Event;

class SingleEventPublisher extends EventPublisher
{
    public static function instance()
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new self();
        }

        return $instance;
    }
}