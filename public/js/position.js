var Position = function (x, y) {
    this._x = !!x ? prepareNumber(x) : 0;
    this._y = !!y ? prepareNumber(y) : 0;
    new NumberProperty(this, 'x');
    new NumberProperty(this, 'y');
};