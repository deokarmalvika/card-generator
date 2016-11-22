var Rectangle = function (position, size, color) {
    ColoredBlock.apply(this, arguments);
};

Rectangle.prototype = Object.create(ColoredBlock.prototype);
Rectangle.prototype.constructor = Rectangle;

Rectangle.prototype.paint = function (context) {
    context.fillStyle = this.color.asString();
    context.fillRect(this.position.x, this.position.y, this.size.w, this.size.h);
};
