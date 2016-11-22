<!doctype html>
<html lang="ru">
<?php include viewPath('common/head.php') ?>
<body>
<div class="card">
    <?php
    if (isset($_POST['show']) || isset($_POST['get'])) {
        ?>
        <img src="<?= $path ?>" alt="result"/>
        <?php
    }
    ?>
</div>
<canvas id="card" style="border: 1px solid #000"></canvas>
<form class="form" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="image-w">Ширина карты</label>
        <input type="text" id="image-w" name="image[w]"
               value="<?= isset($_POST['image']['w']) ? $_POST['image']['w'] : '' ?>"
               onchange="$('#card').attr('width', $(this).val())"/>
    </div>
    <div class="form-group">
        <label for="image-h">Высота карты</label>
        <input type="text" id="image-h" name="image[h]"
               value="<?= isset($_POST['image']['h']) ? $_POST['image']['h'] : '' ?>"
               onchange="$('#card').attr('height', $(this).val())"/>
    </div>
    <div class="form-group">
        <button type="button" data-add-object="image">Картинка</button>
        <button type="button" data-add-object="rectangle">Прямоугольник</button>
        <button type="button" data-add-object="text">Текст</button>
        <button type="button" data-add-object="border">Рамка</button>
    </div>
    <div data-objects>
        <?php
        if (isset($_POST['blocks'])) {
            foreach ($_POST['blocks'] as $key => $block) {
                $method = $block['block-type'] . 'Block';
                echo \NewInventor\CardGenerator\HtmlHelper::$method($key, $block);
            }
        } ?>
    </div>
</form>

<button class="btn btn-default" type="submit" name="get-png" value="PNG"></button>
<button class="btn btn-default" type="submit" name="get-csv" value="CSV"></button>
<button class="btn btn-default" type="submit" name="get-csv-short" value="Short CSV"></button>
<button class="btn btn-default" type="submit" name="get-stack" value="Колода"></button>
<form class="form" action="<?= route('') ?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <input type="file" name="zip"/>
        <input class="btn btn-default" type="submit" name="load-zip" value="Компилировать из ZIP">
    </div>
</form>
<form class="dz-clickable dropzone" id="images-upload" action="<?= route('loadFile') ?>">
</form>
<?php require viewPath('common/scripts.php') ?>
</body>
</html>