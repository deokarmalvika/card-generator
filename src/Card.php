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
     */
    public function __construct($name, $visualBloks)
    {
        $this->name = $name;
        $this->visualBlocks = $visualBloks;
    }

    public function render()
    {

    }
}