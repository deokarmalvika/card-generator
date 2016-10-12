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
    <img src="res.png" alt="result"/>
</div>
<form class="form-inline">
    <div>
        <div data-object-group="1">
            <div class="form-group"><label for="background-color-1">Цвет фона</label><input type="text" id="background-color-1"/></div>
            <div class="form-group"><label for="background-image-1">Картинка фона</label><input type="file" id="background-image-1"/></div>
            <div class="form-group"><label for="object-text-1">Текст</label><input type="text" id="object-text-1"/></div>
            <div class="form-group"><label for="object-border-1">Граница</label><input type="text" id="object-border-1"/></div>
            <div class="form-group"><label for="object-x-1">X</label><input type="text" id="object-x-1"/></div>
            <div class="form-group"><label for="object-y-1">Y</label><input type="text" id="object-y-1"/></div>
            <div class="form-group"><label for="object-w-1">W</label><input type="text" id="object-w-1"/>
            </div>
            <div class="form-group"><label for="object-h-1">H</label><input type="text" id="object-h-1"/></div>
            <div class="form-group"><button type="button" data-add-object>+</button></div>
        </div>
    </div>
    <input class="btn btn-primary" type="submit" value="Посмотреть">
    <input class="btn btn-default" type="button" value="Скачать результат">
</form>
</body>
</html>