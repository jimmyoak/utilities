<?php

namespace JimmyOak\Event;

class EventPublisher
{
    /**
     * @var EventSubscriber[]
     */
    private $subscribers = [];

    /**
     * @param EventSubscriber $subscriber
     *
     * @return $this
     */
    public function subscribe(EventSubscriber $subscriber)
    {
        $this->subscribers[] = $subscriber;

        return $this;
    }

    /**
     * @param Event $event
     *
     * @return $this
     */
    public function publish(Event $event)
    {
        foreach ($this->subscribers as $subscriber) {
            if ($subscriber->isSubscribedTo($event)) {
                $subscriber->handle($event);
            }
        }

        return $this;
    }
}