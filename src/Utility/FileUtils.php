<?php

namespace JimmyOak\Utility;

class FileUtils extends UtilsBase
{
    const FILES = 1;
    const DIRS = 2;
    const ALL = 3;

    /**
     * @param string $path
     * @param int $fileOrDirs
     * @param bool $recursive
     *
     * @return array
     */
    public function scanDir($path, $fileOrDirs = self::ALL, $recursive = true)
    {
        $files = scandir($path);

        $path = $this->stripPathLastDirectorySeparator($path);

        $allFiles = [];
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $pathToScan = $path . DIRECTORY_SEPARATOR . $file;
                if (is_dir($pathToScan)) {
                    if ($recursive) {
                        $moreFiles = $this->scanDir($pathToScan, $fileOrDirs, true);
                        $appendParents = function ($path) use ($file) {
                            return $file . DIRECTORY_SEPARATOR . $path;
                        };
                        $moreFiles = array_map($appendParents, $moreFiles);
                        $allFiles = array_merge($allFiles, $moreFiles);
                    }
                    if ($fileOrDirs & self::DIRS) {
                        $allFiles[] = (string) $file;
                    }
                } else {
                    if ($fileOrDirs & self::FILES) {
                        $allFiles[] = (string) $file;
                    }
                }
            }
        }

        return $allFiles;
    }

    /**
     * @param string $fileName
     * @param string $extension
     *
     * @return bool
     */
    public function extensionIs($fileName, $extension)
    {
        $extensionPregQuoted = preg_quote($extension);
        return preg_match('/\.' . $extensionPregQuoted . '$/i', $fileName) > 0;
    }

    /**
     * @param $path
     *
     * @return string
     */
    private function stripPathLastDirectorySeparator($path)
    {
        $pathLength = strlen($path);
        $pathLastChar = $path[$pathLength - 1];
        $path = $pathLastChar === DIRECTORY_SEPARATOR ? substr($path, 0, -1) : $path;

        return $path;
    }
}
