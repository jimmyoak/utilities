<?php

namespace JimmyOak\Test\Event;

class DomainEventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldReturnOccurredOnDateTime()
    {
        $domainEvent = new TestableDomainEvent();

        $this->assertEquals($this->now(), $domainEvent->getOccurredOn(), 'OccurredOn DateTime is now', 1);
    }

    /**
     * @return \DateTime
     */
    private function now()
    {
        return new \DateTime();
    }
}
