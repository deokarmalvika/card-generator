<?php
/**
 * Date: 11.10.16
 * Time: 13:40
 */

namespace CardGenerator;


class Card
{
    protected $name;
    protected $visualBlocks;

    /**
     * Card constructor.
     * @param $name
     * @param array $visualBloks
     */
    public function __construct($name, array $visualBloks)
    {
        $this->name = $name;
        $this->visualBlocks = $visualBloks;
    }

    public function render()
    {

    }
}