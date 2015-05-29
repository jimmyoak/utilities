<?php

namespace JimmyOak\Collection;

use JimmyOak\Exception\Collection\NotValidObjectTypeException;
use JimmyOak\Exception\Collection\UndefinedOffsetException;
use Traversable;

class TypedCollection extends Collection
{
    /** @var string */
    private $objectType;

    public function __construct($objectType)
    {
        $this->objectType = $objectType;
    }

    public function getObjectType()
    {
        return $this->objectType;
    }

    protected function setObjectType($objectType)
    {
        $this->objectType = $objectType;

        return $this;
    }

    public function offsetSet($offset, $value)
    {
        $this->guardAgainstNotValidObjectType($value);

        parent::offsetSet($offset, $value);
    }

    public function offsetGet($offset)
    {
        if (!isset($this->collection[$offset])) {
            throw new UndefinedOffsetException();
        }

        return parent::offsetGet($offset);
    }

    /**
     * @param $value
     *
     * @throws NotValidObjectTypeException
     */
    private function guardAgainstNotValidObjectType($value)
    {
        if (!$value instanceof $this->objectType) {
            throw new NotValidObjectTypeException();
        }
    }
}
