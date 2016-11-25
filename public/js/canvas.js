(function ($, undefined) {
    var canvas;
    var context;
    var objects;
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
        var count = objects.length;
        for (var i = 0; i < count; i++) {
            objects[i].paint(context);
        }
    };

    $.canvas.clear = function () {
        context.clearRect(0, 0, canvas.width, canvas.height);
    };

    $.canvas.save = function (download, redirectTo) {
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
                if(redirectTo !== undefined) {
                    window.location.href = redirectTo;
                }else if(download !== undefined && download) {
                    window.location.href = '/download/png/' + data.id;
                }
            } else {
                alert('error', data.message);
            }
        });
    };

    $.canvas.toArray = function () {
        var count = objects.length;
        var res = [[$(canvas).attr('width'), $(canvas).attr('height')]];
        for (var i = 0; i < count; i++) {
            res.push($.merge([objects[i].constructor.name], objects[i].toArray()));
        }

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
        var count = data.length;
        for (var i = 0; i < count; i++) {
            if(i === 0){
                $(canvas).attr('width', data[i][0]).attr('height', data[i][1]);
                continue;
            }
            var objectClass = data[i].splice(0, 1);
            objects.push(window[objectClass].fromArray(data[i]));
        }
    }
})(jQuery);

$('canvas').canvas();