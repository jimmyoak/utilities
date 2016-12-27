<?php

namespace JimmyOak\Event;

class SingleEventPublisher extends EventPublisher
{
    private static $instances = [];

    private function __construct()
    {
    }

    public static function instance()
    {
        if (!isset(self::$instances[static::class])) {
            self::$instances[static::class] = new static();
        }

        return self::$instances[static::class];
    }
}