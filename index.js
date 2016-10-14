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
})(jQuery);