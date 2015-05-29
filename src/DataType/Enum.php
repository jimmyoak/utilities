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
    public function getConstList()
    {
        static $constants = null;

        if (null === $constants) {
            $constants = (new \ReflectionClass($this))->getConstants();
        }

        return $constants;
    }

    /**
     * @param $type
     */
    private function guardAgainstValueNotInValidConstants($type)
    {
        if (false === in_array($type, $this->getConstList(), true)) {
            throw new \InvalidArgumentException('Provided value is not valid');
        }
    }
}
