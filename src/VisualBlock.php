<?php
/**
 * Date: 11.10.16
 * Time: 13:46
 */

namespace CardGenerator;


class VisualBlock
{
    protected $backgroundColor = '#fff0';
    protected $backgroundImagePath = '';
    protected $text = '';
    protected $position = ['x' => 0, 'y' => 0];
    protected $size = ['w' => 0, 'h' => 0];
    protected $border = ['color' => '#000', 'width' => 0];

    /**
     * VisualBlock constructor.
     */
    public function __construct(array $data = [])
    {

    }
}