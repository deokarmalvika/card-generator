<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 25.11.2016
 * Time: 13:05
 */

namespace NewInventor\CardGenerator\Helpers;


class FontHelper
{
    public static $fontTypes = ['ttf', 'TTF', 'otf', 'eot', 'woff', 'woff2'];

    public static function getFontFaceStyle($name, $file)
    {
        $format = self::getFontFormat($file);
        $url = "/{$_SESSION['directory']}/fonts/{$file}";
        return "@font-face {\n\tfont-family: '{$name}';\n\tsrc: url('{$url}') format('{$format}')\n}\n\n";
    }

    public static function getFontFormat($file)
    {
        if(preg_match('/(?:\.)(' . implode('|', self::$fontTypes) . ')$/', $file, $matches)){
            if($matches[1] === 'ttf'){
                return 'truetype';
            }elseif($matches[1] === 'eot'){
                return 'embedded-opentype';
            }elseif($matches[1] === 'woff'){
                return 'woff';
            }elseif($matches[1] === 'woff2'){
                return 'woff2';
            }
        }
        return '';
    }

    public static function writeUserFontsCss()
    {
        if(!isset($_SESSION['directory'])){
            return;
        }
        $f = fopen(publicPath($_SESSION['directory'] . '/fonts.css'), 'wb');
        foreach (FileHelper::getFontsList() as $name => $file) {
            fwrite($f, self::getFontFaceStyle($name, $file));
        }
        fclose($f);
    }
}