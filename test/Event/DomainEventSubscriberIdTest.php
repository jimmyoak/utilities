<?php

namespace JimmyOak\Test\Event;

use JimmyOak\Event\DomainEventSubscriberId;

class DomainEventSubscriberIdTest extends \PHPUnit_Framework_TestCase
{
    const DOMAIN_EVENT_SUBSCRIBER_ID = 'asdfasdfasdfasdf';

    /**
     * @test
     */
    public function shouldGenerateWithRandomValueIfNoValueSpecifiedOnConstruction()
    {
        $domainEventSubscriberId = new DomainEventSubscriberId();
        $anotherDomainEventSubscriberId = new DomainEventSubscriberId();

        $this->assertNotEmpty($domainEventSubscriberId->value());
        $this->assertNotEmpty($anotherDomainEventSubscriberId->value());
        $this->assertFalse($domainEventSubscriberId->equals($anotherDomainEventSubscriberId));
    }

    /**
     * @test
     */
    public function shouldGetSpecifiedValueOnCreation()
    {
        $domainEventSubscriberId = new DomainEventSubscriberId(self::DOMAIN_EVENT_SUBSCRIBER_ID);

        $this->assertSame(self::DOMAIN_EVENT_SUBSCRIBER_ID, $domainEventSubscriberId->value());
    }
}
