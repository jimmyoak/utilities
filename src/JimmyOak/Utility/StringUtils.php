<?php

namespace JimmyOak\Utility;

class StringUtils extends UtilsBase
{
    const CASE_INSENSITIVE   = 1;
    const ACCENT_INSENSITIVE = 2;

    private $accentsMap = array(
        'Š' => 'S',
        'š' => 's',
        'Ž' => 'Z',
        'ž' => 'z',
        'À' => 'A',
        'Á' => 'A',
        'Â' => 'A',
        'Ã' => 'A',
        'Ä' => 'A',
        'Å' => 'A',
        'Æ' => 'A',
        'Ç' => 'C',
        'È' => 'E',
        'É' => 'E',
        'Ê' => 'E',
        'Ë' => 'E',
        'Ì' => 'I',
        'Í' => 'I',
        'Î' => 'I',
        'Ï' => 'I',
        'Ñ' => 'N',
        'Ò' => 'O',
        'Ó' => 'O',
        'Ô' => 'O',
        'Õ' => 'O',
        'Ö' => 'O',
        'Ø' => 'O',
        'Ù' => 'U',
        'Ú' => 'U',
        'Û' => 'U',
        'Ü' => 'U',
        'Ý' => 'Y',
        'Þ' => 'B',
        'ß' => 'Ss',
        'à' => 'a',
        'á' => 'a',
        'â' => 'a',
        'ã' => 'a',
        'ä' => 'a',
        'å' => 'a',
        'æ' => 'a',
        'ç' => 'c',
        'è' => 'e',
        'é' => 'e',
        'ê' => 'e',
        'ë' => 'e',
        'ì' => 'i',
        'í' => 'i',
        'î' => 'i',
        'ï' => 'i',
        'ð' => 'o',
        'ñ' => 'n',
        'ò' => 'o',
        'ó' => 'o',
        'ô' => 'o',
        'õ' => 'o',
        'ö' => 'o',
        'ø' => 'o',
        'ù' => 'u',
        'ú' => 'u',
        'û' => 'u',
        'ý' => 'y',
        'þ' => 'b',
        'ÿ' => 'y'
    );

    private $urlRegExp;
    private $emailRegExp;

    protected function __construct()
    {
        $this->urlRegExp = '%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|' .
            '(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{0' .
            '0a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6})' .
            ')(?::\d+)?(?:[^\s]*)?$%iu';

        $this->emailRegExp = '/^([a-z0-9_.-])+@([a-z0-9_.-])+\.([a-z])+([a-z])+/i';
    }

    public function beginsWith($haystack, $needle, $modifiers = null)
    {
        $this->prepareHaystackAndNeedle($haystack, $needle, $modifiers);
        $parsedModifiers = $this->parseModifiers($modifiers);

        $pattern = '/^' . preg_quote($needle) . '/';

        return (bool)preg_match($pattern . $parsedModifiers, $haystack);
    }

    public function removeAccents($string)
    {
        return strtr($string, $this->accentsMap);
    }

    public function endsWith($haystack, $needle, $modifiers = null)
    {
        self::prepareHaystackAndNeedle($haystack, $needle, $modifiers);
        $parsedModifiers = $this->parseModifiers($modifiers);

        $pattern = '/' . preg_quote($needle) . '$/';

        return (bool)preg_match($pattern . $parsedModifiers, $haystack);
    }

    public function removeExtraSpaces($string)
    {
        return trim(preg_replace('/\s+/', ' ', $string));
    }

    private function parseModifiers($modifiers)
    {
        $parsedModifiers = '';

        if ($modifiers & self::CASE_INSENSITIVE) {
            $parsedModifiers .= 'i';
        }

        return $parsedModifiers;
    }

    private function isAccentInsensitiveModifier($modifiers)
    {
        return $modifiers & self::ACCENT_INSENSITIVE;
    }

    private function prepareHaystackAndNeedle(&$haystack, &$needle, $modifiers)
    {
        if ($this->isAccentInsensitiveModifier($modifiers)) {
            $haystack = $this->removeAccents($haystack);
            $needle   = $this->removeAccents($needle);
        }
    }

    public function isUrl($string)
    {
        return preg_match($this->urlRegExp, $string) > 0;
    }

    public function isEmail($string)
    {
        return preg_match($this->emailRegExp, $string) > 0;
    }
}
