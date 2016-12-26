<?php

namespace JimmyOak\Test\Event;

use JimmyOak\Event\SingleDomainEventPublisher;

class SingleDomainEventPublisherTest extends DomainEventPublisherTest
{
    protected function createDomainEventPublisher()
    {
        return SingleDomainEventPublisher::create();
    }

    /**
     * @test
     */
    public function shouldBeSingleton()
    {
        $publisher = SingleDomainEventPublisher::create();
        $samePublisher = SingleDomainEventPublisher::create();

        $this->assertSame($publisher, $samePublisher);
    }
}
