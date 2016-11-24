var Border = function (position, size, color, width) {
    this._width = !!width ? width : 1;
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
