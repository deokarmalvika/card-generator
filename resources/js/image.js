var CanvasImage = function (position, size, url, saveDimensions) {
    this.url = !!url ? url : '';
    this.saveDimensions = !!saveDimensions;
    Block.apply(this, [position, size]);
};

CanvasImage.prototype = Object.create(Block.prototype);
CanvasImage.prototype.constructor = CanvasImage;

CanvasImage.prototype.paint = function (context) {
    var imageObj = new Image();
    var that = this;
    imageObj.onload = function () {
        if (that.saveDimensions) {
            var durationW = that.size.w / imageObj.width;
            var durationH = that.size.h / imageObj.height;
            var width = that.size.w;
            var height = that.size.h;
            if (durationW < durationH) {
                height = imageObj.height * durationW;
            } else {
                width = imageObj.width * durationH;
            }
        }
        context.drawImage(imageObj, that.position.x, that.position.y, width, height);
    };
    imageObj.src = this.url;
};