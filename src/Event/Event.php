<?php

namespace JimmyOak\Event;

abstract class Event
{
    /**
     * @var \DateTime
     */
    private $occurredOn;

    public function __construct()
    {
        $this->occurredOn = new \DateTime();
    }

    /**
     * @return \DateTime
     */
    public function getOccurredOn()
    {
        return $this->occurredOn;
    }
}