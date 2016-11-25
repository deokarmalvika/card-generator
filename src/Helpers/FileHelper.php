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
        $fontsPath = publicPath($_SESSION['directory'] . '/fonts');
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
        $fontsPath = publicPath($_SESSION['directory'] . '/images');
        if (!file_exists($fontsPath)) {
            return [];
        }
        $dir = new \DirectoryIterator($fontsPath);
        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot() && $fileinfo->isFile()) {
                $res[] = $_SESSION['directory'] . '/images/' . $fileinfo->getFilename();
            }
        }

        return $res;
    }

    public static function clearCompiled()
    {
        $fontsPath = publicPath($_SESSION['directory'] . '/done');
        if (!file_exists($fontsPath)) {
            return;
        }
        $dir = new \DirectoryIterator($fontsPath);
        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot() && $fileinfo->isFile()) {
                unlink($fileinfo->getPathname());
            }
        }
    }
}