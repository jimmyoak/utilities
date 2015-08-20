<?php

namespace JimmyOak\DataType;

abstract class Enum
{
    /**
     * @var string
     */
    private $type;

    /**
     * @param mixed $type
     */
    public function __construct($type)
    {
        $this->guardAgainstValueNotInValidConstants($type);
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->type;
    }

    /**
     * @return array
     */
    public static function getConstList()
    {
        static $constants = null;

        if (null === $constants) {
            $constants = (new \ReflectionClass(static::class))->getConstants();
        }

        return $constants;
    }

    /**
     * @param $type
     */
    private function guardAgainstValueNotInValidConstants($type)
    {
        if (!in_array($type, self::getConstList(), true)) {
            throw new \InvalidArgumentException('Provided value is not valid');
        }
    }
}
