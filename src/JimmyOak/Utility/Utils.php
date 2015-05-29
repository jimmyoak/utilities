<?php

namespace JimmyOak\Utility;

class Utils extends UtilsBase
{
    /** @var ArrayUtils */
    public $array;
    /** @var FileUtils */
    public $file;
    /** @var ObjectUtils */
    public $object;
    /** @var StringUtils */
    public $string;

    protected function __construct()
    {
        $this->array = ArrayUtils::instance();
        $this->file = FileUtils::instance();
        $this->object = ObjectUtils::instance();
        $this->string = StringUtils::instance();
    }
}
