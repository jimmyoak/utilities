<?php

namespace JimmyOak\Event;

abstract class EventSubscriber
{
    /**
     * @var EventSubscriberId
     */
    private $id;

    public function __construct()
    {
        $this->id = new EventSubscriberId();
    }

    /**
     * @return EventSubscriberId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Event $event
     *
     * @return bool
     */
    public abstract function isSubscribedTo(Event $event);

    /**
     * @param Event $event
     *
     * @return void
     */
    public abstract function handle(Event $event);
}