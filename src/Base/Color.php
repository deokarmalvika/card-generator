<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 13.10.2016
 * Time: 15:42
 */

namespace NewInventor\CardGenerator\Base;


class Color
{
    protected $red;
    protected $green;
    protected $blue;
    protected $alpha;

    protected static $baseColor = [
        'red' => 255,
        'green' => 255,
        'blue' => 255,
        'alpha' => 0,
    ];

    /**
     * Color constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        if (isset($data[0])) {
            $this->red = (int)$data[0];
        }
        if (isset($data[1])) {
            $this->green = (int)$data[1];
        }
        if (isset($data[2])) {
            $this->blue = (int)$data[2];
        }
        if (isset($data[3])) {
            $this->alpha = (int)$data[3];
        }
    }

    /**
     * @param resource $image
     *
     * @return int
     */
    public function allocateColor($image)
    {
        return imagecolorallocatealpha(
            $image,
            $this->red,
            $this->green,
            $this->blue,
            $this->alpha
        );
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'red' => $this->red,
            'green' => $this->green,
            'blue' => $this->blue,
            'alpha' => $this->alpha
        ];
    }
}