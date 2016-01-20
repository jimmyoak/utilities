<?php

namespace JimmyOak\Collection;

class UniquedTypedCollection extends TypedCollection
{
    public function offsetSet($offset, $value)
    {
        if (!in_array($value, $this->collection, true)) {
            parent::offsetSet($offset, $value);
        }
    }
}
