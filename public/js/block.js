var Block = function (position, size) {
    this.position = position.constructor.name === 'Position' ? position : new Position();
    this.size = size.constructor.name === 'Size' ? size : new Size();
    this.position.x += 0.5;
    this.position.y += 0.5;
};

Block.prototype.paint = function (context) {
    alert('should be implemented in child class');
};
