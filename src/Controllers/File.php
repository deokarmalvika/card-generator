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
        if (self::isImage($file)) {
            echo json_encode(self::moveLoadedFile($file, 'images'));
            return;
        } elseif (self::isCsv($file)) {
            echo json_encode(self::moveLoadedFile($file, '', 'scenario.csv'));
            return;
        } elseif (self::isFont($file)) {
            echo json_encode(self::moveLoadedFile($file, 'fonts'));
            return;
        } elseif (self::isZip($file)) {
            $result = self::moveLoadedFile($file, '', 'stack.zip');
            $zip = new \ZipArchive();
            $path = publicPath(FileHelper::getUserCategory() . '/zip');
            if (!mkdir($path, 0755) && !is_dir($path)) {
                $result = ['success' => false, 'message' => 'Не получилось создать категорию'];
            }
            if ($zip->open($path) === true) {
                $zip->extractTo($path);
                $zip->close();
            }
            echo json_encode($result);
            return;
        }
        echo json_encode(['success' => false, 'message' => 'Не подходящий формат файла.']);
    }

    public static function getImagePath($imageName)
    {
        return ['success' => true, FileHelper::getUserCategory() . '/images/' . $imageName];
    }

    public static function getFontPath($fontName)
    {
        return ['success' => true, FileHelper::getUserCategory() . '/fonts/' . $fontName];
    }

    public static function saveCard()
    {
        $dir = publicPath(FileHelper::getUserCategory() . '/done');
        if (!file_exists($dir) && !@mkdir($dir) && !is_dir($dir)) {
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

    private static function isImage($file)
    {
        return strpos($file['name'], '.jpeg') !== false ||
            strpos($file['name'], '.jpg') !== false ||
            strpos($file['name'], '.png') !== false ||
            strpos($file['name'], '.gif') !== false;
    }

    private static function isCsv($file)
    {
        return strpos($file['name'], '.csv') !== false;
    }

    private static function isFont($file)
    {
        return strpos($file['name'], '.ttf') !== false ||
            strpos($file['name'], '.woff') !== false ||
            strpos($file['name'], '.woff2') !== false ||
            strpos($file['name'], '.otf') !== false ||
            strpos($file['name'], '.eot') !== false;
    }

    private static function isZip($file)
    {
        return strpos($file['name'], '.zip') !== false;
    }

    protected static function moveLoadedFile($file, $subdir = '', $name = '')
    {
        $dir = publicPath("{$_SESSION['directory']}/{$subdir}");
        if (!file_exists($dir) && !@mkdir($dir) && !is_dir($dir)) {
            return ['success' => false];
        }
        if (move_uploaded_file($file['tmp_name'], $dir . '/' . ($name !== '' ? $name : $file['name']))) {
            return ['success' => true];
        }
        return ['success' => false];
    }

    public static function downloadZip() {
        $zip = new \ZipArchive();
        $path = publicPath(FileHelper::getUserCategory() . '/result.zip');
        $zip->open($path, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        $dir = new \DirectoryIterator(publicPath(FileHelper::getUserCategory() . '/done'));
        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot()) {
                $zip->addFile($fileinfo->getPathname(), $fileinfo->getFilename());
            }
        }

        $zip->close();

        self::sendFile($path);
    }

    public static function downloadPng($id)
    {
        self::sendFile(publicPath(FileHelper::getUserCategory() . "/done/{$id}.png"));
    }

    public static function downloadCsv()
    {
        $path = publicPath(FileHelper::getUserCategory() . '/done/card.csv');
        self::sendFile($path);
    }

    public static function saveCsv()
    {
        $cardLayers = $_REQUEST['card'];
        $path = publicPath(FileHelper::getUserCategory() . '/done/card.csv');
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
        $path = publicPath(FileHelper::getUserCategory() . '/scenario.csv');
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