var ColoredBlock = function (position, size, color) {
    Block.apply(this, [position, size]);
    this.color = color.constructor.name === 'Color' ? color : new Color();
};

ColoredBlock.prototype = Object.create(Block.prototype);
ColoredBlock.prototype.constructor = ColoredBlock;