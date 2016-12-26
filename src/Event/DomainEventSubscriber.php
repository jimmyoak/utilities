<?php

namespace JimmyOak\Event;

abstract class DomainEventSubscriber
{
    /**
     * @var DomainEventSubscriberId
     */
    private $id;

    public function __construct()
    {
        $this->id = new DomainEventSubscriberId();
    }

    /**
     * @return DomainEventSubscriberId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param DomainEvent $domainEvent
     *
     * @return bool
     */
    public abstract function isSubscribedTo(DomainEvent $domainEvent);

    /**
     * @param DomainEvent $domainEvent
     *
     * @return void
     */
    public abstract function handle(DomainEvent $domainEvent);
}