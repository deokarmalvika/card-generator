<?php
namespace NewInventor\CardGenerator\Controllers;

use NewInventor\CardGenerator\FileHelper;

class Main
{
    public function home()
    {
        $folder = FileHelper::getUserCategory();
        include viewPath('home.php');
    }
}