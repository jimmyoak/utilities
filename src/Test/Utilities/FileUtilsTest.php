<?php

namespace Test\Utilities;

use Utilities\FileUtils;

class FileUtilsTest extends UtilsBaseTest
{
    /** @var FileUtils */
    protected $utils;

    protected function setUp()
    {
        $this->utils = FileUtils::instance();
    }

    /** @test */
    public function file_extension_is()
    {
        $fileName = 'file.php';
        $isPhp = $this->utils->extensionIs($fileName, 'php');
        $isNot = $this->utils->extensionIs($fileName, 'asd');

        $this->assertTrue($isPhp);
        $this->assertFalse($isNot);
    }
}
