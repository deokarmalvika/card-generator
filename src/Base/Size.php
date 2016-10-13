<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 13.10.2016
 * Time: 15:58
 */

namespace NewInventor\CardGenerator\Base;


class Size extends Vector2D
{
    public function w()
    {
        return $this->x;
    }

    public function h()
    {
        return $this->y;
    }

    public function toArray()
    {
        return ['w' => $this->x, 'h' => $this->y];
    }
}