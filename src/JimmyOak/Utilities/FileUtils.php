<?php

namespace JimmyOak\Utilities;

class FileUtils extends UtilsBase
{
    const FILES = 1;
    const DIRS = 2;
    const ALL = 3;

    public function extensionIs($fileName, $extension)
    {
        $extensionPregQuoted = preg_quote($extension);
        return preg_match('/\.' . $extensionPregQuoted . '$/i', $fileName) > 0;
    }

    public function scandir($path, $fileOrDirs = self::ALL, $recursive = true)
    {
        $files = scandir($path);

        if ($fileOrDirs === self::ALL && !$recursive) {
            return $files;
        }

        $path = $this->stripPathLastDirectorySeparator($path);

        $allFiles = [];
        foreach ($files as $key => $file) {
            if ($file !== '.' && $file !== '..') {
                $pathToScan = $path . DIRECTORY_SEPARATOR . $file;
                if (is_dir($pathToScan)) {
                    if ($recursive) {
                        $moreFiles = $this->scandir($pathToScan, $fileOrDirs, true);
                        $appendParents = function ($path) use ($file) {
                            return $file . DIRECTORY_SEPARATOR . $path;
                        };
                        $moreFiles = array_map($appendParents, $moreFiles);
                        $allFiles = array_merge($allFiles, $moreFiles);
                    }
                    if ($fileOrDirs & self::DIRS) {
                        $allFiles[] = $file;
                    }
                } else {
                    if ($fileOrDirs & self::FILES) {
                        $allFiles[] = $file;
                    }
                }
            }
        }

        return $allFiles;
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
        $path = $pathLastChar === DIRECTORY_SEPARATOR ? substr($path, -1) : $path;
        return $path;
    }
}
