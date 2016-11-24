<!doctype html>
<html lang="ru">
<?php include viewPath('common/head.php') ?>
<body>
<form class="dz-clickable dropzone" id="files-upload" action="<?= route('loadFile') ?>" data-drop-zone></form>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <span class="navbar-brand">Card generator</span>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <form class="navbar-form navbar-left">
                <div class="form-group">
                    <input type="text" class="form-control short-input" placeholder="Ширина" data-width>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control short-input" placeholder="Высота" data-height>
                </div>
            </form>
            <ul class="nav navbar-nav">
                <li><a href="" data-upload-link><i class="fa fa-upload"></i></a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle"
                       data-toggle="dropdown"
                       role="button"
                       aria-haspopup="true"
                       aria-expanded="false"><i class="fa fa-download"></i><span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#">CSV</a></li>
                        <li><a href="#">PNG</a></li>
                        <li><a href="#">ZIP</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="" data-image-block><i class="fa fa-image"></i></a></li>
                <li><a href="" data-font-block><i class="fa fa-font"></i></a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div class="preview-bar">
    <div class="panel panel-info hidden" data-image-panel>
        <div class="panel-heading">Доступные картинки</div>
        <div class="panel-body">
            <p>Если каких-то картинок нехватает, вы всегда можете их загрузить.</p>
        </div>
        <table class="table">

        </table>
    </div>
    <div class="panel panel-info hidden" data-font-panel>
        <div class="panel-heading">Доступные шрифты</div>
        <div class="panel-body">
            <p>Если каких-то шрифтов нехватает, вы всегда можете их загрузить.</p>
        </div>
        <table class="table">

        </table>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <canvas id="card"></canvas>
    </div>
    <div class="col-md-4">
        <div class="row">

        </div>
        <div class="row">
            <div class="scrollPanel col-xs-6" data-images></div>
            <div class="scrollPanel col-xs-6" data-fonts></div>
        </div>
    </div>
</div>
<div class="row text-center">
    <button class="btn btn-default" type="submit" name="get-png">PNG</button>
    <button class="btn btn-default" type="submit" name="get-csv">CSV</button>
    <button class="btn btn-default" type="submit" name="get-csv-short">Short CSV</button>
    <button class="btn btn-default" type="submit" name="get-stack">Колода</button>
</div>

<?php require viewPath('common/scripts.php') ?>
</body>
</html>