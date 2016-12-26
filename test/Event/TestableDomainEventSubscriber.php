<?php

namespace JimmyOak\Test\Event;

use JimmyOak\Event\DomainEvent;
use JimmyOak\Event\DomainEventSubscriber;

class TestableDomainEventSubscriber extends DomainEventSubscriber
{
    /**
     * @param DomainEvent $domainEvent
     *
     * @return bool
     */
    public function isSubscribedTo(DomainEvent $domainEvent)
    {
        return true;
    }

    /**
     * @param DomainEvent $domainEvent
     *
     * @return void
     */
    public function handle(DomainEvent $domainEvent)
    {
        // do nothing
    }
}