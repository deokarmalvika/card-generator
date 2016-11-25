var Color = function (r, g, b, a) {
    this._r = !!r ? prepareNumber(r) : 0;
    this._g = !!g ? prepareNumber(g) : 0;
    this._b = !!b ? prepareNumber(b) : 0;
    this._a = !!a ? prepareNumber(a) : 1;
    new LimitedNumberProperty(this, 'r', 0, 255);
    new LimitedNumberProperty(this, 'g', 0, 255);
    new LimitedNumberProperty(this, 'b', 0, 255);
    new LimitedNumberProperty(this, 'a', 0, 1);
};

Color.parse = function (color, delimiter) {
    var parts = color.split(delimiter);
    return new Color(parts[0], parts[1], parts[2], parts[3]);
};

Color.prototype.asString = function () {
    return 'rgba(' + this._r + ', ' + this._g + ', ' + this._b + ', ' + this._a + ')';
};