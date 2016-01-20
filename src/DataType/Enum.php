<?php

namespace JimmyOak\DataType;

abstract class Enum extends SimpleValueObject
{
    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->guardAgainstValueNotInValidConstants($value);
        parent::__construct($value);
    }

    /**
     * @return array
     */
    public static function getConstList()
    {
        static $constants = array();

        if (!isset($constants[get_called_class()])) {
            $reflectionClass = new \ReflectionClass(get_called_class());
            $constants[get_called_class()] = $reflectionClass->getConstants();
        }

        return $constants[get_called_class()];
    }

    private function guardAgainstValueNotInValidConstants($value)
    {
        if (!in_array($value, self::getConstList(), true)) {
            throw new \InvalidArgumentException(
                sprintf('Provided value for %s is not valid: %s', get_called_class(), $value)
            );
        }
    }
}
