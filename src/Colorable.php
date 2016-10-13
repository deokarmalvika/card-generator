<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 13.10.2016
 * Time: 16:39
 */

namespace NewInventor\CardGenerator;


use NewInventor\CardGenerator\Base\Color;

trait Colorable
{
    /** @var Color */
    protected $color;
    /**
     * @param Color $color
     *
     * @return $this
     */
    public function color(Color $color)
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @return Color
     */
    public function getColor()
    {
        return $this->color;
    }
}