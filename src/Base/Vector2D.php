<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 13.10.2016
 * Time: 16:11
 */

namespace CardGenerator\Base;


class Vector2D
{
    protected $x;
    protected $y;

    /**
     * Position constructor.
     *
     * @param int|float|double $x
     * @param int|float|double $y
     */
    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @return int|float|double
     */
    public function x()
    {
        return $this->x;
    }

    /**
     * @return int|float|double
     */
    public function y()
    {
        return $this->y;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return ['x' => $this->x, 'y' => $this->y];
    }
}