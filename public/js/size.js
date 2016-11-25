var Size = function (w, h) {
    this._w = !!w ? prepareNumber(w) : 0;
    this._h = !!h ? prepareNumber(h) : 0;
    new NumberProperty(this, 'w');
    new NumberProperty(this, 'h');
};