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

    var imagesUpload = $("#images-upload").dropzone({
        url: 'image.php',
        paramName: "image",
        acceptedFiles: 'image/*',
        maxFilesize: 20,
        parallelUploads: 10,
        dictDefaultMessage: 'Перенесите необходимые картинки.',
        dictInvalidFileType: 'Поддерживаются только картинки',
        dictFileTooBig: 'Файл должен быть меньше {{maxFilesize}}. Текущий размер: {{filesize}}',
        complete: function (file) {
            this.removeFile(file);
        }
    });

    var fontsUpload = $("#fonts-upload").dropzone({
        url: 'font.php',
        paramName: "font",
        maxFilesize: 5,
        acceptedFiles: '.ttf,.TTF',
        parallelUploads: 10,
        dictDefaultMessage: 'Перенесите необходимые шрифты.',
        dictInvalidFileType: 'Поддерживаются только файлы шрифтов',
        dictFileTooBig: 'Файл должен быть меньше {{maxFilesize}}. Текущий размер: {{filesize}}',
        complete: function (file) {
            this.removeFile(file);

        }
    });
})(jQuery);