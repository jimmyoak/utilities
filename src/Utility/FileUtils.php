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

        $allFiles = array();
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
     * @var string $tokens ...
     *
     * @return string
     */
    public function makePath()
    {
        $tokens = $this->sanitizePathTokens(func_get_args());

        return implode(DIRECTORY_SEPARATOR, $tokens);
    }

    private function sanitizePathTokens($tokens)
    {
        $sanitized = array();

        foreach ($tokens as $token) {
            if (!in_array($token, array('', DIRECTORY_SEPARATOR), true) && is_string($token)) {
                $sanitized[] = $this->stripPathLastDirectorySeparator($token);
            }
        }

        return $sanitized;
    }

    /**
     * @param $fileName
     *
     * @return string
     */
    public function getExtension($fileName)
    {
        $lastDot = strrpos($fileName, '.');

        if (!$lastDot) {
            return '';
        }

        return substr($fileName, $lastDot + 1);
    }

    /**
     * @param $fileName
     *
     * @return string
     */
    public function getNameWithoutExtension($fileName)
    {
        $lastDot = strrpos($fileName, '.');

        if (!$lastDot) {
            return $fileName;
        }

        return substr($fileName, 0, $lastDot);
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

    private function stripPathLastDirectorySeparator($path)
    {
        $pathLength = strlen($path);
        $pathLastChar = $path[$pathLength - 1];
        $path = $pathLastChar === DIRECTORY_SEPARATOR ? substr($path, 0, -1) : $path;

        return $path;
    }
}
