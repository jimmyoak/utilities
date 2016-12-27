<?php

namespace JimmyOak\Event;

use JimmyOak\DataType\SimpleValueObject;
use Ramsey\Uuid\Uuid;

class EventSubscriberId extends SimpleValueObject
{
    public function __construct($value = null)
    {
        parent::__construct($this->valueOrRandomOnNull($value));
    }

    /**
     * @param $value
     *
     * @return string
     */
    private function valueOrRandomOnNull($value)
    {
        return null === $value ? Uuid::uuid4()->toString() : $value;
    }
}