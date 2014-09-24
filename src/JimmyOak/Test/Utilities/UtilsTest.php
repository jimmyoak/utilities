<?php

namespace JimmyOak\Test\Utilities;

use JimmyOak\Utilities\ArrayUtils;
use JimmyOak\Utilities\FileUtils;
use JimmyOak\Utilities\ObjectUtils;
use JimmyOak\Utilities\StringUtils;
use JimmyOak\Utilities\Utils;

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
