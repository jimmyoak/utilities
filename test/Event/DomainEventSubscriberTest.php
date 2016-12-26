<?php

namespace JimmyOak\Test\Event;

class DomainEventSubscriberTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldHaveAnId()
    {
        $domainEventSubscriber = new TestableDomainEventSubscriber();

        $this->assertNotEmpty($domainEventSubscriber->getId()->value());
    }
}
