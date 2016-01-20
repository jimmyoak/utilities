<?php

namespace JimmyOak\Collection;

class UniquedCollection extends Collection
{
    public function offsetSet($offset, $value)
    {
        if (!in_array($value, $this->collection, true)) {
            parent::offsetSet($offset, $value);
        }
    }
}
