<?php
require __DIR__ . '/vendor/autoload.php';

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
    <link rel="stylesheet" href="index.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
</head>
<body>
<div class="card">
    <?php
    if(isset($_POST['show']) || isset($_POST['get'])) {
        ?>
        <img src="<?= $path ?>" alt="result"/>
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
    <div class="form-group">
        <button type="button" data-add-object="image">Картинка</button>
        <button type="button" data-add-object="rectangle">Прямоугольник</button>
        <button type="button" data-add-object="text">Текст</button>
        <button type="button" data-add-object="border">Рамка</button>
    </div>
    <div data-objects>
        <?php
        if(isset($_POST['blocks'])){
            foreach($_POST['blocks'] as $key => $block){
                $method = $block['block-type'] . 'Block';
                echo \NewInventor\CardGenerator\HtmlHelper::$method($key, $block);
            }
        } ?>
    </div>
    <input class="btn btn-primary" type="submit" name="show" value="Посмотреть">
    <input class="btn btn-default" type="submit" name="get-png" value="PNG">
    <input class="btn btn-default" type="submit" name="get-csv" value="CSV">
    <input class="btn btn-default" type="submit" name="get-csv-shor" value="Short CSV">
</form>

<form class="form" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <input type="file" name="zip"/>
        <input class="btn btn-default" type="submit" name="load-zip" value="Компилировать из ZIP">
    </div>
</form>
<script>
    window.dummy = {
        image: "<?= \NewInventor\CardGenerator\HtmlHelper::imageBlock();?>",
        text: "<?= \NewInventor\CardGenerator\HtmlHelper::textBlock();?>",
        rectangle: "<?= \NewInventor\CardGenerator\HtmlHelper::rectangleBlock();?>",
        border: "<?= \NewInventor\CardGenerator\HtmlHelper::borderBlock();?>"
    }
</script>
<script src="index.js"></script>
</body>
</html>