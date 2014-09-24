<?php

namespace Utilities;

class ArrayUtils extends UtilsBase
{
    const NO_PRESERVE_KEYS = 0;
    const PRESERVE_KEYS = 1;
    const PRESERVE_ASSOCIATIVE_KEYS = 2;

    public function flatten(array $toFlat, $preserveKeys = self::NO_PRESERVE_KEYS)
    {
        if ($preserveKeys === self::PRESERVE_KEYS) {
            $flatten = $this->flattenPreservingKeys($toFlat);
        } elseif ($preserveKeys === self::PRESERVE_ASSOCIATIVE_KEYS) {
            $flatten = $this->flattenPreservingAssociativeKeys($toFlat);
        } else {
            $flatten = $this->flattenNotPreservingKeys($toFlat);
        }

        return $flatten;
    }

    /**
     * @param array $toFlat
     *
     * @internal param $flatten
     *
     * @internal param $preserveKeys
     * @return array
     */
    private function flattenPreservingKeys(array $toFlat)
    {
        $flatten = [];

        foreach ($toFlat as $key => $value) {
            if (is_array($value)) {
                $flatten = array_replace($flatten, $this->flatten($value, self::PRESERVE_KEYS));
            } else {
                $flatten[$key] = $value;
            }
        }

        return $flatten;
    }

    /**
     * @param array $toFlat
     *
     * @internal param $flatten
     *
     * @return array
     */
    private function flattenNotPreservingKeys(array $toFlat)
    {
        $flatten = [];

        foreach ($toFlat as $value) {
            if (is_array($value)) {
                $flatten = array_merge($flatten, $this->flatten($value, self::NO_PRESERVE_KEYS));
            } else {
                $flatten[] = $value;
            }
        }

        return $flatten;
    }

    private function flattenPreservingAssociativeKeys(array $toFlat)
    {
        $flatten = [];

        foreach ($toFlat as $key => $value) {
            if (is_array($value)) {
                $flatten = array_merge($flatten, $this->flatten($value, self::PRESERVE_ASSOCIATIVE_KEYS));
            } elseif (is_int($key)) {
                $flatten[] = $value;
            } else {
                $flatten[$key] = $value;
            }
        }

        return $flatten;
    }

    public function toXmlString(array $data)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';

        $xml .= $this->parseAsXml($data);

        return $xml;
    }

    private function parseAsXml(array $data, $inheritedKey = null)
    {
        $xml = '';

        foreach ($data as $key => $value) {
            if (!is_scalar($value)) {
                if ($this->isAssociative($value) || !$value) {
                    $xml .= $this->parseXmlKeyValue($key, $this->parseAsXml($value));
                } else {
                    $xml .= $this->parseAsXml($value, $key);
                }
            } elseif ($inheritedKey !== null) {
                $xml .= $this->parseXmlKeyValue($inheritedKey, $value);
            } else {
                $xml .= $this->parseXmlKeyValue($key, $value);
            }
        }

        return $xml;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return string
     */
    private function parseXmlKeyValue($key, $value = null)
    {
        if (empty($value)) {
            return "<$key/>";
        }

        return "<$key>" . $value . "</$key>";
    }

    private function isAssociative(array $data)
    {
        $keys = array_keys($data);

        foreach ($keys as $key) {
            if (!is_int($key)) {
                return true;
            }
        }

        return false;
    }

    public function toXml(array $arrayToParseAsXml)
    {
        return simplexml_load_string($this->parseAsXml($arrayToParseAsXml));
    }
}
