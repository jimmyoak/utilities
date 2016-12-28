<?php

namespace JimmyOak\Event;

abstract class Event
{
    /**
     * @var \DateTimeImmutable
     */
    private $occurredOn;

    public function __construct()
    {
        $this->occurredOn = new \DateTimeImmutable();
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getOccurredOn()
    {
        return $this->occurredOn;
    }
}