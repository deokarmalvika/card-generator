var prepareNumber = function(value) {
    if (typeof value !== 'number') {
        value = parseFloat(value);
    }
    return value;
};

var NumberProperty = function (object, name) {
    var privateProp = '_' + name;
    this.get = function () {
        return object[privateProp];
    };
    this.set = function (value) {
        object[privateProp] = prepareNumber(value);
    };
    Object.defineProperty(object, name, this);
};

var LimitedNumberProperty = function (object, name, min, max) {
    var privateProp = '_' + name;
    this.get = function () {
        return object[privateProp];
    };
    this.set = function (value) {
        var prepared = prepareNumber(value);
        if(prepared < min) {
            prepared = min;
        }else if(prepared > max) {
            prepared = max;
        }
        object[privateProp] = prepared;
    };
    Object.defineProperty(object, name, this);
};

window.alert = function(type, text) {
    noty({
        text: text,
        type: type,
        dismissQueue: true,
        layout: 'bottomRight',
        theme: 'bootstrapTheme',
        maxVisible: 10,
        modal: false,
        timeout: 15000
    });
};

var foreach = function (array, callback) {
    var count = array.length;
    for (var i = 0; i < count; i++) {
        callback(array[i], i);
    }
};