<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 13.10.2016
 * Time: 21:07
 */

namespace NewInventor\CardGenerator;


class CardStackGenerator
{
    protected $zipPath;
    protected $unzipPath;

    /**
     * CardStackGenerator constructor.
     * @throws \Exception
     */
    public function __construct(array $fileData = [])
    {
        $this->copyFile($fileData);
        $zip = new \ZipArchive();
        $path = $_SERVER['DOCUMENT_ROOT'] . '/loaded/zip_' . time();
        if (!mkdir($path, 0777) && !is_dir($path)) {
            throw new \Exception('no directory');
        }
        $this->unzipPath = $path;
        if ($zip->open($this->zipPath) === true) {
            $zip->extractTo($path);
            $zip->close();
        }
    }

    public function copyFile($data)
    {
        if ($data['name'] === '') {
            $this->zipPath = '';
        }
        $path = $_SERVER['DOCUMENT_ROOT'] . '/loaded/stack.zip';
        if (move_uploaded_file($data['tmp_name'], $path)) {
            $this->zipPath = $path;
            return;
        }
        $this->zipPath = '';
    }

    public function process()
    {
        $f = fopen($this->unzipPath . '/stack.csv', 'r');
        if($f === false){
            return '/';
        }
        $cardData = [];
        while (!feof($f)) {
            $data = fgetcsv($f, null, ';');
            if($data === false){
                break;
            }
            if ($data[0] !== null) {
                $cardData[] = $data;
                continue;
            }
            $card = Card::fromCsv($cardData, $this->unzipPath);
            $card->render('stack/');
            $cardData = [];
        }
        $card = Card::fromCsv($cardData, $this->unzipPath);
        $card->render('stack/');
        $path = $this->zip();
        $this->removeLoaded($this->unzipPath);
        return $path;
    }

    protected function zip()
    {
        $rootPath = $_SERVER['DOCUMENT_ROOT'] . '/ready/stack';
        $zip = new \ZipArchive();
        $zipPath = '/ready/result_' . time() . '.zip';
        $zip->open(
            $_SERVER['DOCUMENT_ROOT'] . $zipPath,
            \ZipArchive::CREATE | \ZipArchive::OVERWRITE
        );
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($rootPath),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        $filesToDelete = [];
        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);
                $zip->addFile($filePath, $relativePath);
                $filesToDelete[] = $filePath;
            }
        }
        $zip->close();

        foreach ($filesToDelete as $file) {
            unlink($file);
        }
        rmdir($rootPath);
        return $zipPath;
    }

    protected function removeLoaded($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }
        if (!is_dir($dir)) {
            return unlink($dir);
        }
        foreach (scandir($dir) as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }
            if (!$this->removeLoaded($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }
        return rmdir($dir);
    }
}