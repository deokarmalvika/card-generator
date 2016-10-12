<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 12.10.2016
 * Time: 20:50
 */

namespace CardGenerator;


class GdHelper
{
    public static function colorFromArray($image, array $data)
    {
        $color = [
            'red' => 255,
            'green' => 255,
            'blue' => 255,
            'alpha' => 0,
        ];
        if (isset($data[0])) {
            $color['red'] = (int)$data[0];
        }
        if (isset($data[1])) {
            $color['green'] = (int)$data[1];
        }
        if (isset($data[2])) {
            $color['blue'] = (int)$data[2];
        }
        if (isset($data[3])) {
            $color['alpha'] = (int)$data[3];
        }
        return self::allocateColor($image, $color);
    }

    public static function allocateColor($image, array $color)
    {
        return imagecolorallocatealpha(
            $image,
            $color['red'],
            $color['green'],
            $color['blue'],
            $color['alpha']
        );
    }
}