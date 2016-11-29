<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 23.11.2016
 * Time: 10:37
 */

namespace NewInventor\CardGenerator\Helpers;


class FileHelper
{
    /**
     * @return string
     */
    public static function getUserCategory()
    {
        if (!isset($_SESSION['directory'])) {
            $_SESSION['directory'] = self::generateNewCategory();
        }

        return $_SESSION['directory'];
    }

    /**
     * @return string
     */
    public static function generateNewCategory()
    {
        $dirName = time() . '-' . uniqid('', true);
        $dirPath = userDataPath($dirName);
        if (!@mkdir($dirPath) && !is_dir($dirPath)) {
            return '';
        }
        return str_replace(publicPath(), '', $dirPath);
    }

    /**
     * @return array
     */
    public static function getFontsList()
    {
        $res = [];
        $fontsPath = self::getFontsPath();
        if (!file_exists($fontsPath)) {
            return [];
        }
        $dir = new \DirectoryIterator($fontsPath);
        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot() && $fileinfo->isFile()) {
                $name = preg_replace('/\.(?:' . implode('|', FontHelper::$fontTypes) . ')/', '', $fileinfo->getFilename());
                $res[$name] = $fileinfo->getFilename();
            }
        }

        return $res;
    }

    public static function getImagesList()
    {
        $res = [];
        $images = self::getImagesPath();
        if (!file_exists($images)) {
            return [];
        }
        $dir = new \DirectoryIterator($images);
        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot() && $fileinfo->isFile()) {
                $res[] = $images . '/' . $fileinfo->getFilename();
            }
        }

        return $res;
    }

    public static function clearCompiled()
    {
        $donePath = self::getDonePath();
        if (!file_exists($donePath)) {
            return;
        }
        $dir = new \DirectoryIterator($donePath);
        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot() && $fileinfo->isFile()) {
                unlink($fileinfo->getPathname());
            }
        }
    }

    public static function getImagesPath($path = '')
    {
        return publicPath(FileHelper::getUserCategory() . '/images/' . trim($path, TRIM_CHARS));
    }

    public static function getFontsPath($path = '')
    {
        return publicPath(FileHelper::getUserCategory() . '/fonts/' . trim($path, TRIM_CHARS));
    }

    public static function getDonePath($path = '')
    {
        return publicPath(FileHelper::getUserCategory() . '/done/' . trim($path, TRIM_CHARS));
    }

    public static function getTmpZipPath($path = '')
    {
        return publicPath(FileHelper::getUserCategory() . '/zip/' . trim($path, TRIM_CHARS));
    }

    public static function getUserPath($path = '')
    {
        return publicPath(FileHelper::getUserCategory() . '/' . trim($path, TRIM_CHARS));
    }

    public static function accessFolder($path)
    {
        return !file_exists($path) && !@mkdir($path, 755) && !is_dir($path);
    }

    public static function moveUnzippedFiles()
    {
        $fontsPath = self::getTmpZipPath('fonts');
        if (file_exists($fontsPath)) {
            $dir = new \DirectoryIterator($fontsPath);
            foreach ($dir as $fileinfo) {
                if (!$fileinfo->isDot() && $fileinfo->isFile()) {
                    rename($fileinfo->getPathname(), self::getFontsPath($fileinfo->getFilename()));
                }
            }
        }
        $imagesPath = self::getTmpZipPath('images');
        if (file_exists($imagesPath)) {
            $dir = new \DirectoryIterator($imagesPath);
            foreach ($dir as $fileinfo) {
                if (!$fileinfo->isDot() && $fileinfo->isFile()) {
                    rename($fileinfo->getPathname(), self::getImagesPath($fileinfo->getFilename()));
                }
            }
        }
        $scenarioPath = self::getTmpZipPath('scenario.csv');
        if(file_exists($scenarioPath)){
            rename($scenarioPath, self::getUserPath('scenario.csv'));
        }
    }

    public static function clearUnzippedFiles()
    {
        $dir = self::getTmpZipPath();
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $fileinfo) {
            $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
            $todo($fileinfo->getRealPath());
        }

        rmdir($dir);
    }

    public static function isImage($file)
    {
        return strpos($file['name'], '.jpeg') !== false ||
            strpos($file['name'], '.jpg') !== false ||
            strpos($file['name'], '.png') !== false ||
            strpos($file['name'], '.gif') !== false;
    }

    public static function isCsv($file)
    {
        return strpos($file['name'], '.csv') !== false;
    }

    public static function isFont($file)
    {
        return strpos($file['name'], '.ttf') !== false ||
            strpos($file['name'], '.woff') !== false ||
            strpos($file['name'], '.woff2') !== false ||
            strpos($file['name'], '.otf') !== false ||
            strpos($file['name'], '.eot') !== false;
    }

    public static function isZip($file)
    {
        return strpos($file['name'], '.zip') !== false;
    }

    public static function moveLoadedFile($file, $subdir = '', $name = '')
    {
        $dir = FileHelper::getUserPath($subdir);
        if (FileHelper::accessFolder($dir)) {
            return ['success' => false];
        }
        if (move_uploaded_file($file['tmp_name'], $dir . '/' . ($name !== '' ? $name : $file['name']))) {
            return ['success' => true];
        }
        return ['success' => false];
    }
}