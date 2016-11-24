(function ($, undefined) {
    var canvas;
    var context;
    var objects;
    $.fn.canvas = function () {
        if(this.length > 0) {
            if(this[0].getContext){
                canvas = this[0];
                context = canvas.getContext('2d');
                objects = [];
            }else{
                alert('Canvas not supported.');
            }
        }else{
            console.log('No canvas found.');
        }
    };

    $.canvas = {};

    $.canvas.add = function (object) {
        objects.push(object);
    };

    $.canvas.render = function () {
        $.canvas.clear();
        var count = objects.length;
        for(var i = 0; i < count; i++){
            objects[i].paint(context);
        }
    };

    $.canvas.clear = function () {
        context.clearRect(0, 0, canvas.width, canvas.height);
    }
})(jQuery);

$('canvas').canvas();