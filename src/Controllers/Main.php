<?php
namespace NewInventor\CardGenerator\Controllers;

use NewInventor\CardGenerator\Helpers\FileHelper;

class Main
{
    public static function home()
    {
        $folder = FileHelper::getUserCategory();
        include viewPath('home.php');
    }
}