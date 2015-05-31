<?php

namespace JimmyOak\DataType;

use JimmyOak\Collection\Collection;

class ArrayzedObject extends Collection
{
    /** @var string */
    private $class;

    public function __construct($class, $data)
    {
        $this->class = $class;
        $this->collection = $data;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    public function getData()
    {
        return $this->collection;
    }
}
