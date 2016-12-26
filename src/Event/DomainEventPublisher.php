<?php

namespace JimmyOak\Event;

class DomainEventPublisher
{
    /**
     * @var DomainEventSubscriber[]
     */
    private $subscribers = [];

    /**
     * @param DomainEventSubscriber $subscriber
     *
     * @return $this
     */
    public function subscribe(DomainEventSubscriber $subscriber)
    {
        $this->subscribers[] = $subscriber;

        return $this;
    }

    /**
     * @param DomainEvent $domainEvent
     *
     * @return $this
     */
    public function publish(DomainEvent $domainEvent)
    {
        foreach ($this->subscribers as $subscriber) {
            if ($subscriber->isSubscribedTo($domainEvent)) {
                $subscriber->handle($domainEvent);
            }
        }

        return $this;
    }
}