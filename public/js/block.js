var Block = function (position, size) {
    this.position = position.constructor.name === 'Position' ? position : new Position();
    this.size = size.constructor.name === 'Size' ? size : new Size();
    this.position.x -= 0.5;
    this.position.y -= 0.5;
};

Block.prototype.paint = function (context) {
    alert('should be implemented in child class');
};

Block.prototype.update = function (object) {
    this.position.x = object.position.x;
    this.position.y = object.position.y;
    this.size.w = object.size.w;
    this.size.h = object.size.h;
};

Block.prototype.toArray = function () {
    return [this.position.x - 0.5, this.position.y - 0.5, this.size.w, this.size.h];
};

Block.fromArray = function (array) {
    return new Block(
        new Position(array[0], array[1]),
        new Size(array[2], array[3])
    );
};