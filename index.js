/**
 * Created by george on 12.10.16.
 */
(function ($){
    var dummy = '<div data-object-group="%">' +
            '<div class="form-group">' +
                '<label for="background-color-%">Цвет фона</label>' +
                '<input type="text" id="background-color-%"/>' +
            '</div>' +
            '<div class="form-group">' +
                '<label for="background-image-%">Картинка фона</label>' +
                '<input type="file" id="background-image-%"/>' +
            '</div>' +
            '<div class="form-group">' +
                '<label for="object-text-%">Текст</label>' +
                '<input type="text" id="object-text-%"/>' +
            '</div>' +
            '<div class="form-group">' +
                '<label for="object-border-%">Граница</label>' +
                '<input type="text" id="object-border-%"/>' +
            '</div>' +
            '<div class="form-group">' +
                '<label for="object-x-%">X</label>' +
                '<input type="text" id="object-x-%"/>' +
            '</div>' +
            '<div class="form-group">' +
                '<label for="object-y-%">Y</label>' +
                '<input type="text" id="object-y-%"/>' +
            '</div>' +
            '<div class="form-group">' +
                '<label for="object-w-%">W</label>' +
                '<input type="text" id="object-w-%"/>' +
            '</div>' +
            '<div class="form-group">' +
                '<label for="object-h-%">H</label>' +
                '<input type="text" id="object-h-%"/>' +
            '</div>' +
            '<div class="form-group">' +
                '<button type="button" data-add-object>+</button>' +
            '</div>' +
        '</div>';

    $(document).on('click', '[data-add-object]', function (e){
        var $objects = $('[data-object-group]');
        var count = $objects.length;
        var $last = $($objects[count - 1]);
        $last.parent().append($(dummy.replace(/\%/g, '' + count)));
    });
})(jQuery);