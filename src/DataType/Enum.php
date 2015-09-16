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
        static $constants = [];

        if (!isset($constants[static::class])) {
            $constants[static::class] = (new \ReflectionClass(static::class))->getConstants();
        }

        return $constants[static::class];
    }

    /**
     * @param $type
     */
    private function guardAgainstValueNotInValidConstants($type)
    {
        if (!in_array($type, self::getConstList(), true)) {
            throw new \InvalidArgumentException(
                sprintf('Provided value for %s is not valid', get_class($this))
            );
        }
    }
}
