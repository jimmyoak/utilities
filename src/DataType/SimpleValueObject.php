<?php

namespace JimmyOak\DataType;

abstract class SimpleValueObject
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * SimpleValueObject constructor.
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return int|null|string
     */
    public function value()
    {
        return $this->value;
    }

    public function __toString()
    {
        return (string) $this->value();
    }

    public function equals(SimpleValueObject $object)
    {
        return $this->value() === $object->value();
    }

    protected function mutate($newValue)
    {
        return new static($newValue);
    }
}
