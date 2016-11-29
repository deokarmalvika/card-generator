(function ($, undefined) {
    var canvas;
    var context;
    var objects;
    var ready = false;
    $.fn.canvas = function () {
        if (this.length > 0) {
            if (this[0].getContext) {
                canvas = this[0];
                context = canvas.getContext('2d');
                objects = [];
            } else {
                alert('Canvas not supported.');
            }
        } else {
            console.log('No canvas found.');
        }
    };

    $.canvas = {};

    $.canvas.add = function (object) {
        objects.push(object);
    };

    $.canvas.update = function (index, object) {
        var className = objects[index].constructor.name;
        var newObjectClassName = object.constructor.name;
        if (className !== newObjectClassName) {
            alert('error', 'Тип нового объекта не соответствует старому типу.');
        }
        objects[index].update(object);
    };

    $.canvas.all = function () {
        return objects;
    };

    $.canvas.delete = function (index) {
        objects.splice(index, 1);
    };

    $.canvas.render = function () {
        $.canvas.clear();
        ready = false;
        $.canvas.paintBlock(0, true);
    };

    $(document).on('paint-next', function (e, index, raiseEvent) {
        if (index === undefined) {
            index = 0;
        }
        $.canvas.paintBlock(index, raiseEvent);
        if ($.canvas.allPainted() && !ready) {
            ready = true;
            $(document).trigger('canvas-ready');
        }
    });

    $.canvas.paintBlock = function (index, raiseEvent) {
        if (objects[index] === undefined) {
            return;
        }
        if (raiseEvent === undefined) {
            raiseEvent = false;
        }
        objects[index].paint(context, index, raiseEvent);
    };

    $.canvas.clear = function () {
        context.clearRect(0, 0, canvas.width, canvas.height);
        foreach(objects, function (obj) {
            obj.painted = false;
        });
    };

    $.canvas.allPainted = function () {
        var res = true;
        foreach(objects, function (obj) {
            res = res && obj.painted;
        });

        return res;
    };

    $.canvas.save = function () {
        var dataURL = canvas.toDataURL();
        $.ajax({
            type: "POST",
            url: "/save/card",
            data: {
                imgBase64: dataURL
            },
            dataType: 'json'
        }).success(function (data) {
            if (data.success) {
                alert('success', 'Card saved on server.');
                $('document').trigger('canvas-saved', [data.id]);
            } else {
                alert('error', data.message);
            }
        });
    };

    $.canvas.toArray = function () {
        var res = [[$(canvas).attr('width'), $(canvas).attr('height')]];
        foreach(objects, function (obj) {
            res.push($.merge([obj.constructor.name], obj.toArray()));
        });

        $.ajax({
            type: "POST",
            url: "/save/csv",
            data: {
                card: res
            },
            dataType: 'json'
        }).success(function (data) {
            alert('success', 'Card csv saved on server.');
            window.location.href = '/download/csv';
        });
    };

    $.canvas.fromArray = function (data) {
        foreach(data, function (obj, key) {
            if (key === 0) {
                $(canvas).attr('width', obj[0]).attr('height', obj[1]);
                return;
            }
            var objectClass = obj.splice(0, 1);
            objects.push(window[objectClass].fromArray(obj));
        });
    }
})(jQuery);

$('canvas').canvas();