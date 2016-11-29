<!doctype html>
<html lang="ru">
<?php include viewPath('common/head.php') ?>
<body>
<form class="dz-clickable dropzone" id="files-upload" action="<?= route('loadFile') ?>" data-drop-zone></form>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
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
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <form class="navbar-form navbar-left">
                <div class="form-group">
                    <input type="text" class="form-control short-input" placeholder="Ширина" data-width value="200">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control short-input" placeholder="Высота" data-height value="300">
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
                        <li><a href="#" data-load-scenario>CSV</a></li>
                        <li><a href="" data-load-card>PNG</a></li>
                        <li><a href="#" data-load-stack>ZIP</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav">
                <li><a href="" data-rectangle-block data-toggle="modal" data-target="#addBlock"><i class="fa fa-square"></i></a></li>
                <li><a href="" data-border-block data-toggle="modal" data-target="#addBlock"><i class="fa fa-square-o"></i></a></li>
                <li><a href="" data-image-block><i class="fa fa-image"></i></a></li>
                <li><a href="" data-font-block><i class="fa fa-font"></i></a></li>
                <li><a href="" data-execute-scenario><i class="fa fa-play"></i></a></li>
                <li><a href="" data-clear-canvas><i class="fa fa-eraser"></i></a></li>
            </ul>
<!--            <ul class="nav navbar-nav navbar-right">-->
<!--                <li><a href="" data-canvas-block><i class="fa fa-database"></i></a></li>-->
<!--            </ul>-->
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div class="preview-bar">
    <div class="panel panel-info hidden" data-image-panel>
        <div class="panel-heading">Доступные картинки</div>
        <div class="panel-table-wrapper">
            <table class="table table-hover clickable" data-table>
                <?php
                $template = \NewInventor\CardGenerator\Helpers\HtmlHelper::imagePreviewBlock();
                foreach (\NewInventor\CardGenerator\Helpers\FileHelper::getImagesList() as $file) {
                    echo preg_replace('/%url%/', $file, $template);
                }
                ?>
            </table>
        </div>
    </div>
    <div class="panel panel-info hidden" data-font-panel>
        <div class="panel-heading">Доступные шрифты</div>
        <div class="panel-table-wrapper">
            <table class="table table-hover clickable" data-table>
                <?php
                $template = \NewInventor\CardGenerator\Helpers\HtmlHelper::fontPreviewBlock();
                    foreach(\NewInventor\CardGenerator\Helpers\FileHelper::getFontsList() as $name => $file) {
                        echo preg_replace('/%fontName%/', $name, $template);
                    }
                ?>
            </table>
        </div>
    </div>
<!--    <div class="panel panel-info hidden" data-canvas-panel>-->
<!--        <div class="panel-heading">Блоки на карте</div>-->
<!--        <div class="panel-table-wrapper">-->
<!--            <table class="table table-hover clickable" data-table>-->
<!--                --><?php
//
//                ?>
<!--            </table>-->
<!--        </div>-->
<!--    </div>-->
</div>
<div class="modal fade" id="addBlock" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel" data-add-block-title></h4>
            </div>
            <div class="modal-body" data-add-block-content></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                <button type="submit" class="btn btn-primary" data-save-block-button form="block-form">Добавить</button>
            </div>
        </div>
    </div>
</div>

<div class="row text-center"><canvas id="card" width="200" height="300"></canvas></div>

<?php require viewPath('common/scripts.php') ?>
</body>
</html>