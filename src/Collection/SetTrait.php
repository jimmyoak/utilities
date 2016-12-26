<?php

namespace JimmyOak\Collection;

trait SetTrait
{
    public function offsetSet($offset, $value)
    {
        if (!in_array($value, $this->collection, true)) {
            parent::offsetSet($offset, $value);
        }
    }
}
