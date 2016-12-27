<?php

namespace JimmyOak\Test\Event;

class EventSubscriberTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldHaveAnId()
    {
        $eventSubscriber = new TestableEventSubscriber();

        $this->assertNotEmpty($eventSubscriber->getId()->value());
    }
}
