var CanvasImage = function (position, size, url, saveDimensions) {
    this.url = !!url ? url : '';
    this.saveDimensions = !!saveDimensions;
    Block.apply(this, [position, size]);
    this.painted = false;
};

CanvasImage.prototype = Object.create(Block.prototype);
CanvasImage.prototype.constructor = CanvasImage;

CanvasImage.prototype.paint = function (context, index, raiseEvent) {
    var imageObj = new Image();
    var that = this;
    imageObj.src = this.url;
    imageObj.onload = function () {
        var width = that.size.w;
        var height = that.size.h;
        if (that.saveDimensions) {
            var durationW = that.size.w / imageObj.width;
            var durationH = that.size.h / imageObj.height;
            if (durationW < durationH) {
                height = imageObj.height * durationW;
            } else {
                width = imageObj.width * durationH;
            }
        }
        context.drawImage(imageObj, that.position.x, that.position.y, width, height);
        that.painted = true;
        $(document).trigger('paint-next', [index + 1, raiseEvent]);
    };
};

CanvasImage.prototype.update = function (object) {
    Block.prototype.update.apply(this, arguments);
    this.url = object.url;
    this.saveDimensions = object.saveDimensions;
};

CanvasImage.prototype.toArray = function () {
    return $.merge(Block.prototype.toArray.apply(this, arguments), [
        this.url.replace(/^(.*\/)/, ''),
        this.saveDimensions
    ]);
};

CanvasImage.fromArray = function (array) {
    return new CanvasImage(
        new Position(array[0], array[1]),
        new Size(array[2], array[3]),
        array[4],
        array[5]
    );
};