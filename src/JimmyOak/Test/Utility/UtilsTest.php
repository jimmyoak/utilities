<?php

namespace JimmyOak\Test\Utility;

use JimmyOak\Utility\ArrayUtils;
use JimmyOak\Utility\FileUtils;
use JimmyOak\Utility\ObjectUtils;
use JimmyOak\Utility\StringUtils;
use JimmyOak\Utility\Utils;

class UtilsTest extends UtilsBaseTest
{
    /** @var Utils */
    protected $utils;

    protected function setUp()
    {
        $this->utils = Utils::instance();
    }

    /** @test */
    public function container_has_instances_of_utils()
    {
        $this->assertInstanceOf(ArrayUtils::class, $this->utils->array);
        $this->assertInstanceOf(FileUtils::class, $this->utils->file);
        $this->assertInstanceOf(ObjectUtils::class, $this->utils->object);
        $this->assertInstanceOf(StringUtils::class, $this->utils->string);
    }
}
