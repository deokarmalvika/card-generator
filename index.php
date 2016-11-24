<?php
session_start();
var_dump($_SESSION);
require __DIR__ . '/vendor/autoload.php';
\NewInventor\ConfigTool\Config::init(__DIR__ . '/config');
require_once __DIR__ . '/functions.php';
\NewInventor\CardGenerator\Router::handleRequest();


function preparePostData(){
    if (isset($_FILES['blocks'])) {
        foreach ($_POST['blocks'] as $key => $block) {
            if ($block['block-type'] !== 'image') {
                continue;
            }
            $data = [
                'name' => $_FILES['blocks']['name'][$key]['image'],
                'type' => $_FILES['blocks']['type'][$key]['image'],
                'tmp_name' => $_FILES['blocks']['tmp_name'][$key]['image'],
                'error' => $_FILES['blocks']['error'][$key]['image'],
                'size' => $_FILES['blocks']['size'][$key]['image'],
            ];
            $res = \NewInventor\CardGenerator\Elements\Image::copyFiles($data);
            if ($res !== []) {
                $_POST['blocks'][$key] = array_merge($_POST['blocks'][$key], $res);
            }
        }
    }
}

if(isset($_POST['load-zip'])){
    $generator = new \NewInventor\CardGenerator\CardStackGenerator($_FILES['zip']);
    $path = $generator->process();
    if($path !== '/') {
        header("Location: $path");
        die();
    }
}

if (isset($_POST['get-png']) || isset($_POST['show']) || isset($_POST['get-csv']) || isset($_POST['get-csv-short'])) {
    preparePostData();
    $card = new \NewInventor\CardGenerator\Card(
        $_POST['image']['w'],
        $_POST['image']['h'],
        $_POST['blocks']
    );
}
if (isset($_POST['get-png'])) {
    $path = $card->render();
    header("Location: $path");
}
if (isset($_POST['show'])) {
    $path = $card->render();
}
if(isset($_POST['get-csv'])){
    $path = $card->toCsv();
    header("Location: $path");
}
if(isset($_POST['get-csv-short'])){
    $path = $card->toCsv();
    header("Location: $path");
}

session_write_close();