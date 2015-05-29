<?php

namespace JimmyOak\Test\Utility;

use JimmyOak\Utility\FileUtils;

class FileUtilsTest extends UtilsBaseTest
{
    /** @var FileUtils */
    protected $utils;
    /** @var string */
    private $testableDir;

    protected function setUp()
    {
        $this->testableDir = __DIR__ . '/../Value/ScanneableDir';
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

    /** @test */
    public function shouldScanAllFilesAndDirsFromADir()
    {
        $expected = [
            'AFile.txt',
            'AnotherDir',
            'AnotherFile.txt',
        ];

        $scanned = $this->utils->scanDir($this->testableDir, FileUtils::ALL, false);

        $this->assertSame($expected, $scanned);
    }

    /** @test */
    public function shouldScanOnlyFilesFromADir()
    {
        $expected = [
            'AFile.txt',
            'AnotherFile.txt',
        ];

        $scanned = $this->utils->scanDir($this->testableDir, FileUtils::FILES, false);

        $this->assertSame($expected, $scanned);
    }

    /** @test */
    public function shouldScanOnlyDirsFromADir()
    {
        $expected = [
            'AnotherDir',
        ];

        $scanned = $this->utils->scanDir($this->testableDir, FileUtils::DIRS, false);

        $this->assertSame($expected, $scanned);
    }


    /** @test */
    public function shouldScanAllFilesAndDirsFromADirRecursively()
    {
        $expected = [
            'AFile.txt',
            'AnotherDir'.DIRECTORY_SEPARATOR.'AnotherDirIntoDir'.DIRECTORY_SEPARATOR.'AFarAwayFile.txt',
            'AnotherDir'.DIRECTORY_SEPARATOR.'AnotherDirIntoDir',
            'AnotherDir'.DIRECTORY_SEPARATOR.'AnotherFileIntoDir.txt',
            'AnotherDir',
            'AnotherFile.txt',
        ];

        $scanned = $this->utils->scanDir($this->testableDir, FileUtils::ALL, true);

        $this->assertSame($expected, $scanned);
    }

    /** @test */
    public function shouldScanOnlyFilesFromADirRecursively()
    {
        $expected = [
            'AFile.txt',
            'AnotherDir'.DIRECTORY_SEPARATOR.'AnotherDirIntoDir'.DIRECTORY_SEPARATOR.'AFarAwayFile.txt',
            'AnotherDir'.DIRECTORY_SEPARATOR.'AnotherFileIntoDir.txt',
            'AnotherFile.txt',
        ];

        $scanned = $this->utils->scanDir($this->testableDir, FileUtils::FILES, true);

        $this->assertSame($expected, $scanned);
    }

    /** @test */
    public function shouldScanOnlyDirsFromADirRecursively()
    {
        $expected = [
            'AnotherDir'.DIRECTORY_SEPARATOR.'AnotherDirIntoDir',
            'AnotherDir',
        ];

        $scanned = $this->utils->scanDir($this->testableDir, FileUtils::DIRS, true);

        $this->assertSame($expected, $scanned);
    }
}
