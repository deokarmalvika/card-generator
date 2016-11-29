/**
 * Created by george on 12.10.16.
 */
(function ($, undefined) {
    Dropzone.autoDiscover = false;

    var $uploadBlock = $("#files-upload");
    var fileExtensions = ['.jpg', '.png', '.gif', '.jpeg', '.ttf', '.TTF', '.otf', '.eot', '.woff', '.woff2', '.csv', '.zip'];
    var fontExtensions = ['.ttf', '.TTF', '.otf', '.eot', '.woff', '.woff2'];
    var imageExtensions = ['.jpg', '.png', '.gif', '.jpeg'];
    $uploadBlock.dropzone({
        url: $uploadBlock.attr('action'),
        paramName: "file",
        acceptedFiles: fileExtensions.join(','),
        maxFilesize: 20,
        parallelUploads: 10,
        dictDefaultMessage: 'Перенесите необходимые файлы.',
        dictInvalidFileType: 'Поддерживаются только картинки, шрифты, csv и zip файлы',
        dictFileTooBig: 'Файл должен быть меньше {{maxFilesize}}. Текущий размер: {{filesize}}',
        success: function (file) {
            alert(file.status, 'File "' + file.name + '" ' + 'loaded to the server.');
            if(isImage(file.name)){
                addImageBlock($('meta[name=userFolder]').attr('content') + '/images/' + file.name);
            }else if(isFont(file.name)){
                var fontStyleName = getFontName(file);
                loadFont(file);
                addFontBlock(fontStyleName);
            }else if(isCsv(file.name)){

            }else if(isZip(file.name)){

            }
            this.removeFile(file);
        },
        drop: function () {
            hideDropZone();
        },
        error: function (file) {
            alert(file.status, 'File "' + file.name + '" ' + 'not loaded to the server.' + (!file.accepted ? ' Wrong file type.' : ' Uncatchable error'));
        },
        queuecomplete: function () {
            hideDropZone();
        }
    });

    function isImage(name){
        var count = imageExtensions.length;
        for(var i = 0; i < count; i++){
            if(name.indexOf(imageExtensions[i]) > -1){
                return true;
            }
        }
        return false;
    }

    function isFont(name){
        var count = fontExtensions.length;
        for (var i = 0; i < count; i++) {
            if (name.indexOf(fontExtensions[i]) > -1) {
                return true;
            }
        }
        return false;
    }

    function isCsv(name){
        return name.indexOf('csv') > -1;
    }

    function isZip(name){
        return name.indexOf('zip') > -1;
    }

    function getFontName(font) {
        return font.name.replace(new RegExp('(' + fileExtensions.join('|').replace('.', '\\.') + ')', 'ig'), '');
    }

    function addFontBlock(fontName) {
        $('[data-font-panel] [data-table]').append(window.dummy.fontPreview.replace(/%fontName%/ig, fontName));
    }

    function addImageBlock(url) {
        $('[data-image-panel] [data-table]').append(window.dummy.imagePreview.replace(/%url%/ig, url));
    }

    function loadFont(font) {
        var css = $('<style></style>');
        css.text("@font-face {font-family: '" + getFontName(font) + "';src: url('/" + $('meta[name=userFolder]').attr('content') + '/fonts/' + font.name + "')}");
        $('head').append(css);
    }

    $(document).on('dragleave', '[data-drop-zone]', function () {
        hideDropZone();
    });

    function hideDropZone() {
        $('[data-drop-zone]').css('left', '-100%').css('right', '100%');
    }

    $(document).on('input change', '[data-width]', function () {
        $('#card').attr('width', parseInt($(this).val()));
        $.canvas.render();
    });

    $(document).on('input change', '[data-height]', function () {
        $('#card').attr('height', parseInt($(this).val()));
        $.canvas.render();
    });

    $(document).on('click', '[data-upload-link]', function (e) {
        e.preventDefault();
        $("#files-upload").click();
    });

    $(document).on('dragover', 'body', function () {
        $('[data-drop-zone]').css('left', '0').css('right', '0');
    });

    $(document).on('click', '[data-image-block]', function (e) {
        e.preventDefault();
        $(this).closest('li').toggleClass('active');
        $('[data-image-panel]').toggleClass('hidden');
    });

    $(document).on('click', '[data-font-block]', function (e) {
        e.preventDefault();
        $(this).closest('li').toggleClass('active');
        $('[data-font-panel]').toggleClass('hidden');
    });

    $(document).on('click', '[data-canvas-block]', function (e) {
        e.preventDefault();
        $(this).closest('li').toggleClass('active');
        $('[data-canvas-panel]').toggleClass('hidden');
    });

    $(document).on('click', '[data-rectangle-block]', function () {
        $('[data-add-block-title]').text('Добавление прямоугольника');
        $('[data-save-block-button]').text('Добавить');
        $('[data-add-block-content]').html($(window.dummy.rectangle));
    });

    $(document).on('click', '[data-border-block]', function () {
        $('[data-add-block-title]').text('Добавление рамки');
        $('[data-save-block-button]').text('Добавить');
        $('[data-add-block-content]').html($(window.dummy.border));
    });

    $(document).on('click', '[data-clear-canvas]', function (e) {
        e.preventDefault();
        $('canvas').canvas();
        $.canvas.render();
    });

    $(document).on('submit', '[data-block-form]', function (e) {
        e.preventDefault();
        var $form = $(this);
        var blockType = $form.data('block-form');
        var object = undefined;
        var position = new Position($form.getFieldValue('x'), $form.getFieldValue('y'));
        var size = new Size($form.getFieldValue('w'), $form.getFieldValue('h'));
        if (blockType === 'rectangle') {
            object = new Rectangle(
                position,
                size,
                Color.parse($form.getFieldValue('color'), ' ')
            );
        } else if (blockType === 'border') {
            object = new Border(
                position,
                size,
                Color.parse($form.getFieldValue('color'), ' '),
                $form.getFieldValue('width')
            );
        } else if (blockType === 'text') {
            object = new CanvasText(
                position,
                size,
                Color.parse($form.getFieldValue('color'), ' '),
                $form.getFieldValue('text'),
                new Font(
                    $form.getFieldValue('font'),
                    $form.getFieldValue('font-size'),
                    $form.getFieldValue('line-height'),
                    $form.getFieldValue('align'),
                    $form.getFieldValue('baseline'),
                    $form.getFieldValue('direction')
                )
            );
        } else if (blockType === 'image') {
            object = new CanvasImage(
                position,
                size,
                $form.getFieldValue('url'),
                $form.getFieldValue('save-dimensions') !== undefined
            );
        }
        $.canvas.add(object);
        $.canvas.render();
        $('#addBlock').modal('toggle');
    });

    $(document).on('click', '[data-font-preview]', function () {
        $('[data-add-block-title]').text('Добавление текста');
        $('[data-save-block-button]').text('Добавить');
        $('[data-add-block-content]').html($(window.dummy.text.replace(/%font%/ig, $(this).data('font-preview'))));
    });

    $(document).on('click', '[data-image-preview]', function () {
        $('[data-add-block-title]').text('Добавление картинки');
        $('[data-save-block-button]').text('Добавить');
        $('[data-add-block-content]').html($(window.dummy.image.replace(/%url%/ig, $(this).data('image-preview'))));
    });

    $(document).on('click', '[data-load-card]', function (e) {
        e.preventDefault();
        $.canvas.save('png');
    });

    $(document).on('click', '[data-load-scenario]', function (e) {
        e.preventDefault();
        $.canvas.toArray();
    });

    $(document).on('click', '[data-execute-scenario]', function (e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: "/scenario",
            dataType: 'json'
        }).success(function (data) {
            var count = data.length;
            var i;
            for (i = 0; i < count; i++) {
                var blockCount = data[i].length;
                for(var j = 0; j < blockCount; j++){
                    if(data[i][j][0] === 'CanvasImage'){
                        data[i][j][5] = $('meta[name=userFolder]').attr('content') + '/images/' + data[i][j][5];
                    }
                }
            }
            i = 0;
            var $canvas = $('canvas');
            $canvas.canvas();
            $.canvas.fromArray(data[i]);
            $.canvas.render(true);
            $(document).on('canvas-saved', function () {
                i++;
                if(data[i] === undefined){
                    $(document).off('canvas-saved');
                    $.canvas.download('zip');
                    return;
                }
                $canvas.canvas();
                $.canvas.fromArray(data[i]);
                $.canvas.render(true);
            });
        });
    });
})(jQuery);