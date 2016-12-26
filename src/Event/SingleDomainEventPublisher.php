<?php

namespace JimmyOak\Event;

class SingleDomainEventPublisher extends DomainEventPublisher
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