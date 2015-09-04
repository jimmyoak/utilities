<?php

namespace JimmyOak\Test\DataType;

use JimmyOak\DataType\SimpleValueObject;

class TestableValueObject extends SimpleValueObject
{
    public function modify($value)
    {
        return $this->duplicateWith($value);
    }
}
