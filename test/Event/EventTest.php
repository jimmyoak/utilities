<?php

namespace JimmyOak\Test\Event;

class EventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldReturnOccurredOnDateTime()
    {
        $event = new TestableEvent();

        $this->assertEquals($this->now(), $event->getOccurredOn(), 'OccurredOn DateTime is now', 1);
    }

    /**
     * @return \DateTimeImmutable
     */
    private function now()
    {
        return new \DateTimeImmutable();
    }
}
