<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 13.10.2016
 * Time: 17:33
 */

namespace NewInventor\CardGenerator\Elements;


interface ApplyToImage
{
    /**
     * @param resource $image
     */
    public function putOnImage($image);
}