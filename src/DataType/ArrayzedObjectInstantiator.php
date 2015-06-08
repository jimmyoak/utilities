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
        if ($this->isSpecialCase($arrayzedObject)) {
            return $this->createSpecialCaseInstance($arrayzedObject);
        }

        $instance = $this->createClassInstance($arrayzedObject);
        
        $this->fillClassInstance($instance, $arrayzedObject->getData());

        return $instance;
    }

    private function createClassInstance(ArrayzedObject $arrayzedObject)
    {
        $instance = (new \ReflectionClass($arrayzedObject->getClass()))->newInstanceWithoutConstructor();

        return $instance;
    }

    private function fillClassInstance($instance, $data)
    {
        $instantiator = $this;
        $valueProcessor = function ($value) use (&$valueProcessor, $instantiator) {
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

    private function isSpecialCase(ArrayzedObject $arrayzedObject)
    {
        return is_subclass_of($arrayzedObject->getClass(), \DateTimeInterface::class);
    }

    private function createSpecialCaseInstance(ArrayzedObject $arrayzedObject)
    {
        try {
            $instance = (new \ReflectionClass($arrayzedObject->getClass()))->newInstanceWithoutConstructor();
        } catch (\ReflectionException $e) {
            $instance = (new \ReflectionClass($arrayzedObject->getClass()))->newInstance();
        }

        $reflectionClass = new \ReflectionClass(\DateTime::class);
        $dateTimeConstructor = $reflectionClass->getConstructor();

        $data = $arrayzedObject->getData();
        $date = isset($data['date']) ? $data['date'] : null;
        $dateTimeZone = isset($data['timezone']) ? $data['timezone'] : null;
        $dateTimeConstructor->invokeArgs($instance, [$date, new \DateTimeZone($dateTimeZone)]);

        return $instance;
    }
}
