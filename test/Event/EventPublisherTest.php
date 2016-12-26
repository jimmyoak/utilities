<?php

namespace JimmyOak\Test\Event;

use JimmyOak\Event\Event;
use JimmyOak\Event\EventPublisher;
use JimmyOak\Event\EventSubscriber;

class EventPublisherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EventPublisher
     */
    private $eventPublisher;
    /**
     * @var EventSubscriber | \PHPUnit_Framework_MockObject_MockObject
     */
    private $eventSubscriber;

    protected function setUp()
    {
        $this->eventSubscriber = $this->getMockBuilder(EventSubscriber::class)->getMock();
        $this->eventPublisher = $this->createEventPublisher();
    }

    /**
     * @return EventPublisher
     */
    protected function createEventPublisher()
    {
        return new EventPublisher();
    }

    /**
     * @test
     */
    public function shouldPublishEventToSubscribersSubscribedToThatEvent()
    {
        $event = new TestableEvent();

        $this->eventSubscriberWillBeSubscribedTo($event);
        $this->eventSubscriberWillHandleOnce($event);

        $this->eventPublisher
            ->subscribe($this->eventSubscriber)
            ->publish($event);
    }

    /**
     * @test
     */
    public function shouldNotPublishEventToSubscribersNonSubscribedToThatEvent()
    {
        $event = new TestableEvent();

        $this->eventSubscriberWillNotBeSubscribedTo($event);
        $this->eventSubscriberWillNotHandle($event);

        $this->eventPublisher
            ->subscribe($this->eventSubscriber)
            ->publish($event);
    }

    private function eventSubscriberWillBeSubscribedTo(Event $event)
    {
        $this->eventSubscriber
            ->expects($this->once())
            ->method('isSubscribedTo')
            ->with($event)
            ->willReturn(true);
    }

    private function eventSubscriberWillNotBeSubscribedTo(Event $event)
    {
        $this->eventSubscriber
            ->expects($this->once())
            ->method('isSubscribedTo')
            ->with($event)
            ->willReturn(false);
    }

    private function eventSubscriberWillHandleOnce(Event $event)
    {
        $this->eventSubscriber
            ->expects($this->once())
            ->method('handle')
            ->with($event);
    }

    private function eventSubscriberWillNotHandle(Event $event)
    {
        $this->eventSubscriber
            ->expects($this->never())
            ->method('handle')
            ->with($event);
    }
}
