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
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->value();
    }

    /**
     * @param SimpleValueObject $object
     *
     * @return bool
     */
    public function equals(SimpleValueObject $object)
    {
        return $this->value() === $object->value();
    }

    /**
     * @param mixed $newValue
     *
     * @return static
     */
    protected function mutate($newValue)
    {
        return new static($newValue);
    }
}
