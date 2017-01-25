<?php

namespace JimmyOak\Utility;

class ObjectUtils extends UtilsBase
{
    const SHALLOW = false;
    const DEEP = true;

    /** @var ArrayUtils */
    private $arrayUtils;

    protected function __construct()
    {
        $this->arrayUtils = ArrayUtils::instance();
    }

    /**
     * @param object $objectToParse
     * @param bool $deep
     *
     * @return \SimpleXMLElement
     */
    public function toXml($objectToParse, $deep = self::SHALLOW)
    {
        return simplexml_load_string($this->toXmlString($objectToParse, $deep));
    }

    /**
     * @param object $object
     * @param bool $deep
     *
     * @return string
     */
    public function toXmlString($object, $deep = self::SHALLOW)
    {
        return $this->arrayUtils->toXmlString($this->toArray($object, $deep));
    }

    /**
     * @param object $object
     * @param bool $deep
     *
     * @return array
     */
    public function toArray($object, $deep = self::SHALLOW)
    {
        return $deep ? $this->toDeepArray($object) : $this->toShallowArray($object);
    }

    private function toDeepArray($object)
    {
        $array = [];

        if ($this->isDateTimeExtensionObject($object)) {
            return $this->parseDateTimeExtensionObject($object);
        }

        $vars = $this->getAllObjectVarsOrArrayProperties($object);

        foreach ($vars as $property => $value) {
            if (is_object($value) || is_array($value)) {
                $array[$property] = $this->toDeepArray($value);
            } elseif (is_resource($value)) {
                $array[$property] = (string)$value;
            } else {
                $array[$property] = $value;
            }
        }

        return $array;
    }

    private function isDateTimeExtensionObject($object)
    {
        return $object instanceof \DateTimeInterface
            || $object instanceof \DateInterval
            || $object instanceof \DateTimeZone;
    }

    private function parseDateTimeExtensionObject($object)
    {
        if ($object instanceof \DateTimeInterface) {
            return $object->format(\DateTime::ISO8601);
        } elseif ($object instanceof \DateInterval) {
            return $object->format('P%yY%mM%dDT%hH%iM%sS');
        } elseif ($object instanceof \DateTimeZone) {
            return $object->getName();
        }

        return (string) $object;
    }

    private function getAllObjectVarsOrArrayProperties($object)
    {
        if (is_object($object)) {
            $vars = $this->getAllObjectVars($object);
        } else {
            $vars = $object;
        }
        return $vars;
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

    private function toShallowArray($object)
    {
        $array = [];

        if ($this->isDateTimeExtensionObject($object)) {
            return $this->parseDateTimeExtensionObject($object);
        }

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
