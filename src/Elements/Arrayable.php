<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 13.10.2016
 * Time: 17:21
 */

namespace NewInventor\CardGenerator\Elements;


interface Arrayable
{
    /**
     * @return array
     */
    public function toArray();
}