<?php

namespace JimmyOak\Test\Event;

use JimmyOak\Event\Event;
use JimmyOak\Event\EventSubscriber;

class TestableEventSubscriber extends EventSubscriber
{
    /**
     * @param Event $event
     *
     * @return bool
     */
    public function isSubscribedTo(Event $event)
    {
        return true;
    }

    /**
     * @param Event $event
     *
     * @return void
     */
    public function handle(Event $event)
    {
        // do nothing
    }
}