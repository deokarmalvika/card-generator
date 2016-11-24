<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 22.11.2016
 * Time: 22:03
 */

namespace NewInventor\CardGenerator\Controllers;


use NewInventor\CardGenerator\FileHelper;

class File
{
    public function loadFile()
    {
        $file = $_FILES['file'];
        if($this->isImage($file)){
            return $this->loadImage($file);
        }elseif($this->isCsv($file)){
            return $this->loadCsv($file);
        }elseif($this->isFont($file)){
            return $this->loadFont($file);
        }elseif($this->isZip($file)){
            return $this->loadZip($file);
        }
        return json_encode(['success' => false, 'message' => 'Не подходящий формат файла.']);
    }

    public function getImagePath($imageName)
    {
        return ['success' => true, FileHelper::getUserCategory() . '/images/' . $imageName];
    }

    public function getFontPath($fontName)
    {
        return ['success' => true, FileHelper::getUserCategory() . '/fonts/' . $fontName];
    }

    public function saveCard()
    {

    }
}