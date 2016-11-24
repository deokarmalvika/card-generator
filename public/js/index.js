/**
 * Created by george on 12.10.16.
 */
(function ($){
    $(document).on('click', '[data-add-object]', function (e){
        var count = parseInt($('[data-object-group]:last').data('object-group'));
        if(isNaN(count)){
            count = -1;
        }
        $('[data-objects]')
            .append(
                $(window.dummy[$(this).data('add-object')].replace(/\%/g, '' + (count + 1)))
            );
    });

    $(document).on('click', '[data-delete-object]', function (e){
        $(this).closest('[data-object-group]').remove();
    });


    function getFontPath(file) {
        $.ajax({
            url: ''
        });
    }

    function loadFont(path) {
        var css = $('<style></style>');
        css.text("@font-face {font-family: '" + path.match(/\/([^\/.]+)\.ttf/)[1] + "';src: url('" + path + "') format('truetype')}");
        $('head').append(css);
    }

    Dropzone.autoDiscover = false;

    var filesUpload = $("#files-upload").dropzone({
        url: 'image.php',
        paramName: "file",
        acceptedFiles: 'image/*,.ttf,.TTF,.csv,.zip',
        maxFilesize: 20,
        parallelUploads: 10,
        dictDefaultMessage: 'Перенесите необходимые файлы.',
        dictInvalidFileType: 'Поддерживаются только картинки, шрифты, csv и zip файлы',
        dictFileTooBig: 'Файл должен быть меньше {{maxFilesize}}. Текущий размер: {{filesize}}',
        complete: function (file) {
            if(file.status === 'error'){
                alert(file.status, 'File "' + file.name + '" ' + 'not loaded to the server.' + (!file.accepted ? ' Wrong file type.' : ' Uncatchable error'));
            }else if(file.status === 'success'){
                alert(file.status, 'File "' + file.name + '" ' + 'loaded to the server.');
            }

            this.removeFile(file);
        },
        queuecomplete: function (file){
            $('[data-drop-zone]').css('left', '-100%').css('right', '100%');
        }
    });

    $(document).on('input change', '[data-width]', function (e) {
        $('#card').attr('width', parseInt($(this).val()));
    });

    $(document).on('input change', '[data-height]', function (e) {
        $('#card').attr('height', parseInt($(this).val()));
    });

    $(document).on('click', '[data-upload-link]', function (e) {
        e.preventDefault();
        $("#files-upload").click();
    });

    $(document).on('dragover', 'body', function(e) {
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
})(jQuery);