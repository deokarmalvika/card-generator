<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 13.10.2016
 * Time: 16:34
 */

namespace CardGenerator\Elements;


use CardGenerator\Base\Position;
use CardGenerator\Base\Size;

abstract class CardObject
{
    protected $position;
    protected $size;

    /**
     * CardObject constructor.
     *
     * @param $position
     * @param $size
     */
    public function __construct(Position $position, Size $size)
    {
        $this->position = $position;
        $this->size = $size;
    }


    /**
     * @param int $x
     * @param int $y
     *
     * @return $this
     */
    public function position($x = 0, $y = 0)
    {
        $this->position = new Position($x, $y);
        return $this;
    }

    /**
     * @return Position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $w
     * @param int $h
     *
     * @return $this
     */
    public function size($w = 0, $h = 0)
    {
        $this->size = new Size($w, $h);

        return $this;
    }

    /**
     * @return Size
     */
    public function getSize()
    {
        return $this->size;
    }

    public function toArray()
    {
        return[
            'position' => $this->position->toArray(),
            'size' => $this->size->toArray(),
        ];
    }
}