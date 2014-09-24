<?php

namespace Utilities;

abstract class UtilsBase
{
    protected function __construct()
    {

    }

    public static function instance()
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new static();
        }

        return $instance;
    }

    public function __clone()
    {
        throw new \Exception('Singleton class, use instance() method');
    }
}
