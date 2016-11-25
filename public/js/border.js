var Border = function (position, size, color, width) {
    this._width = !!width ? prepareNumber(width) : 1;
    new NumberProperty(this, 'width');
    Rectangle.apply(this, [position, size, color]);
};

Border.prototype = Object.create(Rectangle.prototype);
Border.prototype.constructor = Border;

Border.prototype.paint = function (context) {
    context.strokeStyle = this.color.asString();
    context.lineWidth = this._width;
    context.lineCap = 'butt';
    context.lineJoin = 'miter';
    context.strokeRect(this.position.x, this.position.y, this.size.w, this.size.h);
};

Border.prototype.update = function (object) {
    Rectangle.prototype.update.apply(this, arguments);
    this.width = object.width;
};

Border.prototype.toArray = function () {
    return $.merge(Rectangle.prototype.toArray.apply(this, arguments), [this.width]);
};

Border.fromArray = function (array) {
    return new Border(
        new Position(array[0], array[1]),
        new Size(array[2], array[3]),
        new Color(array[4], array[5], array[6], array[7]),
        array[8]
    );
};