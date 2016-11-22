var Size = function (w, h) {
    this._w = !!w ? w : 0;
    this._h = !!h ? h : 0;
    new NumberProperty(this, 'w');
    new NumberProperty(this, 'h');
};