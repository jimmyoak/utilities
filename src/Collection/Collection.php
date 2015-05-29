<?php

namespace JimmyOak\Collection;

class Collection implements \ArrayAccess, \Countable, \IteratorAggregate
{
    /** @var array */
    protected $collection = [];

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
        return $this->collection[$offset];
    }

    public function offsetSet($offset, $value)
    {
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

    public function getIterator()
    {
        return new \ArrayIterator($this->collection);
    }
}
