<?php

namespace JimmyOak\Collection;

use JimmyOak\Exception\Collection\NotValidObjectTypeException;
use JimmyOak\Exception\Collection\UndefinedOffsetException;

class Collection implements \ArrayAccess, \Countable, \Iterator
{
    /** @var string */
    private $objectType;
    /** @var array */
    protected $collection = [];
    /** @var int */
    private $position = 0;

    public function __construct($objectType)
    {
        $this->objectType = $objectType;
    }

    public function getObjectType()
    {
        return $this->objectType;
    }

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->collection[$offset]);
    }

    public function offsetGet($offset)
    {
        if (!isset($this->collection[$offset])) {
            throw new UndefinedOffsetException();
        }
        return $this->collection[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->guardAgainstNotValidObjectType($value);

        if ($offset === null) {
            $this->collection[] = $value;
        } else {
            $this->collection[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->collection[$offset]);
    }

    public function count()
    {
        return count($this->collection);
    }

    public function current()
    {
        return $this->collection[$this->position];
    }

    public function next()
    {
        $this->position++;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        return $this->offsetExists($this->position);
    }

    public function rewind()
    {
        reset($this->collection);
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
