<?php

namespace JimmyOak\DataType;

class ArrayzedObjectFactory
{
    public function create($object)
    {
        return new ArrayzedObject(get_class($object), $this->arrayzeObjectVars($object));
    }

    private function arrayzeObjectVars($object)
    {
        $arrayzedObjectFactory = $this;

        $valueProcessor = function ($value) use (&$valueProcessor, $arrayzedObjectFactory) {
            if (is_object($value)) {
                $value = $arrayzedObjectFactory->create($value);
            } elseif (is_array($value)) {
                foreach ($value as &$innerValue) {
                    $innerValue = $valueProcessor($innerValue);
                }
            }

            return $value;
        };

        $getObjectVarsClosure = function () use ($valueProcessor) {
            return array_map($valueProcessor, get_object_vars($this));
        };

        $vars = [];
        $class = get_class($object);
        do {
            $bindedGetObjectVarsClosure = \Closure::bind($getObjectVarsClosure, $object, $class);
            $vars = array_merge($vars, $bindedGetObjectVarsClosure());
        } while ($class = get_parent_class($class));

        return $vars;
    }
}
