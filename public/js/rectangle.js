var Rectangle = function (position, size, color) {
    ColoredBlock.apply(this, arguments);
};

Rectangle.prototype = Object.create(ColoredBlock.prototype);
Rectangle.prototype.constructor = Rectangle;

Rectangle.prototype.paint = function (context) {
    context.fillStyle = this.color.asString();
    context.fillRect(this.position.x, this.position.y, this.size.w, this.size.h);
};

Rectangle.fromArray = function (array) {
    return new Rectangle(
        new Position(array[0], array[1]),
        new Size(array[2], array[3]),
        new Color(array[4], array[5], array[6], array[7])
    );
};