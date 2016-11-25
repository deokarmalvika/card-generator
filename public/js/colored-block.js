var ColoredBlock = function (position, size, color) {
    Block.apply(this, [position, size]);
    this.color = color.constructor.name === 'Color' ? color : new Color();
};

ColoredBlock.prototype = Object.create(Block.prototype);
ColoredBlock.prototype.constructor = ColoredBlock;

ColoredBlock.prototype.update = function (object) {
    Block.prototype.update.apply(this, arguments);
    this.color.r = object.color.r;
    this.color.g = object.color.g;
    this.color.b = object.color.b;
    this.color.a = object.color.a;
};

ColoredBlock.prototype.toArray = function () {
    return $.merge(Block.prototype.toArray.apply(this, arguments), [this.color.r, this.color.g, this.color.b, this.color.a]);
};

ColoredBlock.fromArray = function (array) {
    return new ColoredBlock(
        new Position(array[0], array[1]),
        new Size(array[2], array[3]),
        new Color(array[4], array[5], array[6], array[7])
    );
};