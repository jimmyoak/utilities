<?php

namespace JimmyOak\DataType;

abstract class Enum
{
    /**
     * @var string
     */
    private $value;

    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->guardAgainstValueNotInValidConstants($value);
        $this->value = $value;
    }

    /**
     * @return string
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
        return (string) $this->value;
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
