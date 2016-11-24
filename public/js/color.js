var Color = function (r, g, b, a) {
    this._r = !!r ? r : 0;
    this._g = !!g ? g : 0;
    this._b = !!b ? b : 0;
    this._a = !!a ? a : 1;
    new LimitedNumberProperty(this, 'r', 0, 255);
    new LimitedNumberProperty(this, 'g', 0, 255);
    new LimitedNumberProperty(this, 'b', 0, 255);
    new LimitedNumberProperty(this, 'a', 0, 1);
};

Color.prototype.asString = function () {
    return 'rgba(' + this._r + ', ' + this._g + ', ' + this._b + ', ' + this._a + ')';
};