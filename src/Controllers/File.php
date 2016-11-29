<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 22.11.2016
 * Time: 22:03
 */

namespace NewInventor\CardGenerator\Controllers;


use NewInventor\CardGenerator\Helpers\FileHelper;

class File
{
    public static function loadFile()
    {
        $file = $_FILES['file'];
        if (FileHelper::isImage($file)) {
            echo json_encode(FileHelper::moveLoadedFile($file, 'images'));
            return;
        } elseif (FileHelper::isCsv($file)) {
            echo json_encode(FileHelper::moveLoadedFile($file, '', 'scenario.csv'));
            return;
        } elseif (FileHelper::isFont($file)) {
            echo json_encode(FileHelper::moveLoadedFile($file, 'fonts'));
            return;
        } elseif (FileHelper::isZip($file)) {
            $result = FileHelper::moveLoadedFile($file, '', 'stack.zip');
            $zip = new \ZipArchive();
            $path = FileHelper::getUserPath('stack.zip');
            $tmpPath = FileHelper::getTmpZipPath();
            if (FileHelper::accessFolder($tmpPath)) {
                $result = ['success' => false, 'message' => 'Не получилось создать категорию'];
            }
            if ($zip->open($path) === true) {
                $zip->extractTo($tmpPath);
                $zip->close();
                FileHelper::moveUnzippedFiles();

            }
            echo json_encode($result);
            return;
        }
        echo json_encode(['success' => false, 'message' => 'Не подходящий формат файла.']);
    }

    public static function saveCard()
    {
        $dir = FileHelper::getDonePath();
        if (FileHelper::accessFolder($dir)) {
            echo json_encode(['success' => false, 'message' => 'Не получилось создать категорию']);
            return;
        }
        if(!isset($_SESSION['done_count'])){
            $_SESSION['done_count'] = 1;
        }
        $_SESSION['done_count']++;
        $img = $_POST['imgBase64'];
        $img = str_replace(['data:image/png;base64,', ' '], ['', '+'], $img);
        $fileData = base64_decode($img);
        file_put_contents($dir . '/' . $_SESSION['done_count'] . '.png', $fileData);
        echo json_encode(['success' => true, 'id' => $_SESSION['done_count']]);
    }

    public static function downloadZip() {
        $zip = new \ZipArchive();
        $path = FileHelper::getUserPath('result.zip');
        $zip->open($path, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        $dir = new \DirectoryIterator(FileHelper::getDonePath());
        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot()) {
                $zip->addFile($fileinfo->getPathname(), $fileinfo->getFilename());
            }
        }

        $zip->close();

        self::sendFile($path);
    }

    public static function downloadCardPng($id)
    {
        self::sendFile(FileHelper::getDonePath("{$id}.png"));
    }

    public static function downloadCardCsv()
    {
        self::sendFile(FileHelper::getDonePath('card.csv'));
    }

    public static function downloadCardZip()
    {
        echo 'not implemented';
    }

    public static function saveCsv()
    {
        $cardLayers = $_REQUEST['card'];
        $path = FileHelper::getDonePath('card.csv');
        $f = fopen($path, 'wb');
        foreach ($cardLayers as $layer) {
            fputcsv($f, $layer, ';');
        }

        fclose($f);

        echo json_encode(['success' => true]);
    }

    protected static function sendFile($path)
    {
        if (file_exists($path)) {
            if (ob_get_level()) {
                ob_end_clean();
            }
            self::setDownloadHeaders($path);
            if ($fd = fopen($path, 'rb')) {
                while (!feof($fd)) {
                    print fread($fd, 1024);
                }
                fclose($fd);
            }
        }
    }

    protected static function setDownloadHeaders($path)
    {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($path));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($path));
    }

    public static function getScenario()
    {
        $path = FileHelper::getUserPath('scenario.csv');
        if (!file_exists($path)) {
            echo json_encode([]);
            return;
        }

        $f = fopen($path, 'rb');
        if ($f === false) {
            echo json_encode([]);
            return;
        }
        $stackData = [];
        $cardData = [];
        while (!feof($f)) {
            $data = fgetcsv($f, null, ';');
            if ($data === false) {
                break;
            }
            if ($data[0] !== null) {
                $cardData[] = $data;
                continue;
            }
            $stackData[] = $cardData;
            $cardData = [];
        }
        $stackData[] = $cardData;
        FileHelper::clearCompiled();
        echo json_encode($stackData);
    }
}