<?php
require __DIR__ . '/vendor/autoload.php';
if (isset($_POST['show']) || isset($_POST['get-png'])) {
    foreach ($_POST['blocks'] as $key => $block) {
        $_POST['blocks'][$key]['background-image']['name'] = $_FILES['blocks']['name'][$key]['background-image'];
        $_POST['blocks'][$key]['background-image']['type'] = $_FILES['blocks']['type'][$key]['background-image'];
        $_POST['blocks'][$key]['background-image']['tmp_name'] = $_FILES['blocks']['tmp_name'][$key]['background-image'];
        $_POST['blocks'][$key]['background-image']['error'] = $_FILES['blocks']['error'][$key]['background-image'];
        $_POST['blocks'][$key]['background-image']['size'] = $_FILES['blocks']['size'][$key]['background-image'];
    }
    $card = new \CardGenerator\Card(__DIR__ . '/res.png', $_POST['image']['w'], $_POST['image']['h'], $_POST['blocks']);
    $card->render();
}
if(isset($_POST['get-csv'])){
    foreach ($_POST['blocks'] as $key => $block) {
        $_POST['blocks'][$key]['background-image']['name'] = $_FILES['blocks']['name'][$key]['background-image'];
        $_POST['blocks'][$key]['background-image']['type'] = $_FILES['blocks']['type'][$key]['background-image'];
        $_POST['blocks'][$key]['background-image']['tmp_name'] = $_FILES['blocks']['tmp_name'][$key]['background-image'];
        $_POST['blocks'][$key]['background-image']['error'] = $_FILES['blocks']['error'][$key]['background-image'];
        $_POST['blocks'][$key]['background-image']['size'] = $_FILES['blocks']['size'][$key]['background-image'];
    }
    $card = new \CardGenerator\Card(__DIR__ . '/res.png', $_POST['image']['w'], $_POST['image']['h'], $_POST['blocks']);
    $card->toCsv();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Card Generator</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="index.js"></script>
</head>
<body>
<div class="card">
    <?php
    if(isset($_POST['show']) || isset($_POST['get'])) {
        ?>
        <img src="res.png" alt="result"/>
        <?php
    }
    ?>
</div>
<form class="form" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="image-w">Ширина карты</label>
        <input type="text" id="image-w" name="image[w]" value="<?= isset($_POST['image']['w']) ? $_POST['image']['w'] : '' ?>"/>
    </div>
    <div class="form-group">
        <label for="image-h">Высота карты</label>
        <input type="text" id="image-h" name="image[h]" value="<?= isset($_POST['image']['h']) ? $_POST['image']['h'] : '' ?>"/>
    </div>
    <div>
        <?php
        $blocks = isset($_POST['blocks']) ? $_POST['blocks'] : [[
            'background-color' => '',
            'background-image' => '',
            'background-image-opacity' => '',
            'text' => '',
            'border' => '',
            'x' => '',
            'y' => '',
            'w' => '',
            'h' => '',
        ]];
        foreach($blocks as $key => $block){
        ?>
        <div data-object-group="<?=$key?>">
            <div class="form-group"><label for="background-color-<?=$key?>">Цвет фона</label><input type="text" id="background-color-<?=$key?>" name="blocks[<?=$key?>][background-color]" value="<?=$block['background-color']?>"/></div>
            <div class="form-group"><label for="background-image-<?=$key?>">Картинка фона</label><input type="file" id="background-image-<?=$key?>" name="blocks[<?=$key?>][background-image]" value="<?=$block['background-image']?>"/></div>
            <div class="form-group"><label for="background-image-opacity-<?=$key?>">Прозрачность</label><input type="text" id="background-image-opacity-<?=$key?>" name="blocks[<?=$key?>][background-image-opacity]" value="<?=$block['background-image-opacity']?>"/></div>
            <div class="form-group"><label for="object-text-<?=$key?>">Текст</label><input type="text" id="object-text-<?=$key?>" name="blocks[<?=$key?>][text]" value="<?=$block['text']?>"/></div>
            <div class="form-group"><label for="object-border-<?=$key?>">Граница</label><input type="text" id="object-border-<?=$key?>" name="blocks[<?=$key?>][border]" value="<?=$block['border']?>"/></div>
            <div class="form-group"><label for="object-x-<?=$key?>">X</label><input type="text" id="object-x-<?=$key?>" name="blocks[<?=$key?>][x]" value="<?=$block['x']?>"/></div>
            <div class="form-group"><label for="object-y-<?=$key?>">Y</label><input type="text" id="object-y-<?=$key?>" name="blocks[<?=$key?>][y]" value="<?=$block['y']?>"/></div>
            <div class="form-group"><label for="object-w-<?=$key?>">W</label><input type="text" id="object-w-<?=$key?>" name="blocks[<?=$key?>][w]" value="<?=$block['w']?>"/></div>
            <div class="form-group"><label for="object-h-<?=$key?>">H</label><input type="text" id="object-h-<?=$key?>" name="blocks[<?=$key?>][h]" value="<?=$block['h']?>"/></div>
            <div class="form-group">
                <button type="button" data-add-object>+</button>
                <button type="button" data-delete-object>-</button>
            </div>
        </div>
        <?php } ?>
    </div>
    <input class="btn btn-primary" type="submit" name="show" value="Посмотреть">
    <input class="btn btn-default" type="submit" name="get-png" value="Скачать результат как PNG">
    <input class="btn btn-default" type="submit" name="get-csv" value="Скачать результат как CSV">
</form>
</body>
</html>