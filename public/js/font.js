var Font = function (name, size, lineHeight, align, baseline, direction) {
    this.name = !!name ? name : 'arial';
    this._size = !!size ? prepareNumber(size) : 12;
    this._lineHeight = !!lineHeight ? prepareNumber(lineHeight) : 12;
    this.align = !!align ? align : 'left';//start, end, left, right, center
    this.baseline = !!baseline ? baseline : 'bottom';//top, hanging, middle, alphabetic, ideographic, bottom
    this.direction = !!direction ? direction : 'inherit';//ltr, rtl, inherit
    new NumberProperty(this, 'size');
    new NumberProperty(this, 'lineHeight');
    setTimeout(function () {}, 500);
};

Font.prototype.applyFont = function (context) {
    context.font = this.size + 'px ' + this.name;
    context.textBaseline = this.baseline;
    context.textAlign = this.align;
    context.direction = this.direction;
};