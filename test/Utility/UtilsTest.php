<?php

namespace JimmyOak\Test\Utility;

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
    public function containerHasInstancesOfUtils()
    {
        $this->assertInstanceOf('\JimmyOak\Utility\ArrayUtils', $this->utils->array);
        $this->assertInstanceOf('\JimmyOak\Utility\FileUtils', $this->utils->file);
        $this->assertInstanceOf('\JimmyOak\Utility\ObjectUtils', $this->utils->object);
        $this->assertInstanceOf('\JimmyOak\Utility\StringUtils', $this->utils->string);
    }
}
