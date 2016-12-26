<?php

namespace JimmyOak\Test\Event;

use JimmyOak\Event\SingleDomainEventPublisher;

class SingleDomainEventPublisherTest extends DomainEventPublisherTest
{
    protected function createDomainEventPublisher()
    {
        return SingleDomainEventPublisher::instance();
    }

    /**
     * @test
     */
    public function shouldBeSingleton()
    {
        $publisher = SingleDomainEventPublisher::instance();
        $samePublisher = SingleDomainEventPublisher::instance();

        $this->assertSame($publisher, $samePublisher);
    }
}
