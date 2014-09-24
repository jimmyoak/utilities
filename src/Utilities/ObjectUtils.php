<?php

namespace Utilities;

class ObjectUtils extends UtilsBase
{
    /** @var ArrayUtils */
    private $arrayUtils;

    protected function __construct()
    {
        $this->arrayUtils = ArrayUtils::instance();
    }

    public function toArray($object)
    {
        $array = [];

        foreach ($object as $property => $value) {
            if (is_object($value)) {
                $array[$property] = $this->toArray($value);
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
}
