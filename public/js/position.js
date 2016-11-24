var Position = function (x, y) {
    this._x = !!x ? x : 0;
    this._y = !!y ? y : 0;
    new NumberProperty(this, 'x');
    new NumberProperty(this, 'y');
};