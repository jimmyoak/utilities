<?php

namespace JimmyOak\Test\Event;

use JimmyOak\Event\EventSubscriberId;

class EventSubscriberIdTest extends \PHPUnit_Framework_TestCase
{
    const EVENT_SUBSCRIBER_ID = 'asdfasdfasdfasdf';

    /**
     * @test
     */
    public function shouldGenerateWithRandomValueIfNoValueSpecifiedOnConstruction()
    {
        $eventSubscriberId = new EventSubscriberId();
        $anotherEventSubscriberId = new EventSubscriberId();

        $this->assertNotEmpty($eventSubscriberId->value());
        $this->assertNotEmpty($anotherEventSubscriberId->value());
        $this->assertFalse($eventSubscriberId->equals($anotherEventSubscriberId));
    }

    /**
     * @test
     */
    public function shouldGetSpecifiedValueOnCreation()
    {
        $eventSubscriberId = new EventSubscriberId(self::EVENT_SUBSCRIBER_ID);

        $this->assertSame(self::EVENT_SUBSCRIBER_ID, $eventSubscriberId->value());
    }
}
