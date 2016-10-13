<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 13.10.2016
 * Time: 17:34
 */

namespace CardGenerator\Elements;


use CardGenerator\Base\Position;
use CardGenerator\Base\Size;

interface CardObjectInterface
{
    public static function make();

    /**
     * @param int $x
     * @param int $y
     *
     * @return $this
     */
    public function position($x = 0, $y = 0);

    /**
     * @return Position
     */
    public function getPosition();

    /**
     * @param int $w
     * @param int $h
     *
     * @return $this
     */
    public function size($w = 0, $h = 0);

    /**
     * @return Size
     */
    public function getSize();
}