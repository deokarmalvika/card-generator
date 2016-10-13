<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 13.10.2016
 * Time: 17:20
 */

namespace CardGenerator\Elements;


interface CsvInterface
{
    /**
     * @return string[]
     */
    public function getParamNames();

    /**
     * @return array
     */
    public function toCsvArray();
}