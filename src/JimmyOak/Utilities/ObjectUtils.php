<?php

namespace JimmyOak\Utilities;

class ObjectUtils extends UtilsBase
{
    /** @var ArrayUtils */
    private $arrayUtils;

    protected function __construct()
    {
        $this->arrayUtils = ArrayUtils::instance();
    }

    public function toArray($object, $deep = false)
    {
        return $deep ? $this->toDeepArray($object) : $this->toShallowArray($object);
    }

    private function toDeepArray($object)
    {
        $array = [];

        if (is_object($object)) {
            $vars = $this->getAllObjectVars($object);
        } else {
            $vars = $object;
        }

        foreach ($vars as $property => $value) {
            if (is_object($value) || is_array($value)) {
                $array[$property] = $this->toDeepArray($value);
            } elseif (is_resource($value)) {
                $array[$property] = (string) $value;
            } else {
                $array[$property] = $value;
            }
        }

        return $array;
    }

    public function toXmlString($object)
    {
        return $this->arrayUtils->toXmlString($this->toArray($object));
    }

    public function toXml($objectToParse)
    {
        return simplexml_load_string($this->toXmlString($objectToParse));
    }

    private function getAllObjectVars($object)
    {
        $getObjectVarsClosure = function () {
            return get_object_vars($this);
        };

        $vars = [];
        $class = get_class($object);
        do {
            $bindedGetObjectVarsClosure = \Closure::bind($getObjectVarsClosure, $object, $class);
            $vars = array_merge($vars, $bindedGetObjectVarsClosure());
        } while ($class = get_parent_class($class));

        return $vars;
    }

    /**
     * @param $object
     *
     * @return array
     */
    private function toShallowArray($object)
    {
        $array = [];

        foreach ($object as $property => $value) {
            if (is_object($value) || is_array($value)) {
                $array[$property] = $this->toShallowArray($value);
            } elseif (is_resource($value)) {
                $array[$property] = (string)$value;
            } else {
                $array[$property] = $value;
            }
        }

        return $array;
    }
}
