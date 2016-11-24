<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 23.11.2016
 * Time: 10:37
 */

namespace NewInventor\CardGenerator;


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
        $relativePath = userDataPath($dirName);
        $dirPath = basePath($relativePath);
        if (!@mkdir($dirPath) && !is_dir($dirPath)) {
            return '';
        }
        return $relativePath;
    }
}