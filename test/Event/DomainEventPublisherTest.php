<?php

namespace JimmyOak\Test\Event;

use JimmyOak\Event\DomainEvent;
use JimmyOak\Event\DomainEventPublisher;
use JimmyOak\Event\DomainEventSubscriber;

class DomainEventPublisherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DomainEventPublisher
     */
    private $domainEventPublisher;
    /**
     * @var DomainEventSubscriber | \PHPUnit_Framework_MockObject_MockObject
     */
    private $domainEventSubscriber;

    protected function setUp()
    {
        $this->domainEventSubscriber = $this->getMockBuilder(DomainEventSubscriber::class)->getMock();
        $this->domainEventPublisher = $this->createDomainEventPublisher();
    }

    /**
     * @return DomainEventPublisher
     */
    protected function createDomainEventPublisher()
    {
        return new DomainEventPublisher();
    }

    /**
     * @test
     */
    public function shouldPublishEventToSubscribersSubscribedToThatEvent()
    {
        $domainEvent = new TestableDomainEvent();

        $this->domainEventSubscriberWillBeSubscribedTo($domainEvent);
        $this->domainEventSubscriberWillHandleOnce($domainEvent);

        $this->domainEventPublisher
            ->subscribe($this->domainEventSubscriber)
            ->publish($domainEvent);
    }

    /**
     * @test
     */
    public function shouldNotPublishEventToSubscribersNonSubscribedToThatEvent()
    {
        $domainEvent = new TestableDomainEvent();

        $this->domainEventSubscriberWillNotBeSubscribedTo($domainEvent);
        $this->domainEventSubscriberWillNotHandle($domainEvent);

        $this->domainEventPublisher
            ->subscribe($this->domainEventSubscriber)
            ->publish($domainEvent);
    }

    private function domainEventSubscriberWillBeSubscribedTo(DomainEvent $domainEvent)
    {
        $this->domainEventSubscriber
            ->expects($this->once())
            ->method('isSubscribedTo')
            ->with($domainEvent)
            ->willReturn(true);
    }

    private function domainEventSubscriberWillNotBeSubscribedTo(DomainEvent $domainEvent)
    {
        $this->domainEventSubscriber
            ->expects($this->once())
            ->method('isSubscribedTo')
            ->with($domainEvent)
            ->willReturn(false);
    }

    private function domainEventSubscriberWillHandleOnce(DomainEvent $domainEvent)
    {
        $this->domainEventSubscriber
            ->expects($this->once())
            ->method('handle')
            ->with($domainEvent);
    }

    private function domainEventSubscriberWillNotHandle(DomainEvent $domainEvent)
    {
        $this->domainEventSubscriber
            ->expects($this->never())
            ->method('handle')
            ->with($domainEvent);
    }
}
