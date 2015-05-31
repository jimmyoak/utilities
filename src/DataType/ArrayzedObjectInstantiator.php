<?php

namespace JimmyOak\DataType;

class ArrayzedObjectInstantiator
{
    /**
     * @param ArrayzedObject $arrayzedObject
     *
     * @return mixed
     */
    public function instantiate(ArrayzedObject $arrayzedObject)
    {
        $instance = $this->createClassInstance($arrayzedObject);

        $this->fillClassInstance($instance, $arrayzedObject->getData());

        return $instance;
    }

    private function createClassInstance(ArrayzedObject $arrayzedObject)
    {
        $serializedObject = 'O:' . strlen($arrayzedObject->getClass()) . ':"' . $arrayzedObject->getClass() . '":0:{}';

        return unserialize($serializedObject);
    }

    private function fillClassInstance($instance, $data)
    {
        $instantiator = $this;
        $valueProcessor = function($value) use (&$valueProcessor, $instantiator) {
            if ($value instanceof ArrayzedObject) {
                $value = $instantiator->instantiate($value);
            }

            if (is_array($value)) {
                foreach ($value as &$innerValue) {
                    $innerValue = $valueProcessor($innerValue);
                }
            }

            return $value;
        };

        $setObjectVarsClosure = function ($data, $class, &$valueProcessor) {
            foreach ($data as $property => $value) {
                if (property_exists($class, $property)) {
                    $value = $valueProcessor($value);
                    $this->$property = $value;
                }
            }
        };

        $class = get_class($instance);
        do {
            $bindedSetObjectVarsClosure = \Closure::bind($setObjectVarsClosure, $instance, $class);
            $bindedSetObjectVarsClosure($data, $class, $valueProcessor);
        } while ($class = get_parent_class($class));
    }
}
