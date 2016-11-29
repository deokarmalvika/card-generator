var CanvasText = function (position, size, color, text, font) {
    this.text = !!text ? text : '';
    this.font = font.constructor.name === 'Font' ? font : new Font();
    ColoredBlock.apply(this, [position, size, color]);
    this.painted = false;
};

CanvasText.prototype = Object.create(ColoredBlock.prototype);
CanvasText.prototype.constructor = CanvasText;

CanvasText.prototype.paint = function (context, index, raiseEvent) {
    context.fillStyle = this.color.asString();
    this.font.applyFont(context);
    var lines = this.getTextLines(this.text, this.size.w, context);
    var count = lines.length;
    for (var i = 0; i < count; i++) {
        context.fillText(lines[i], this.position.x, this.position.y + (i * this.font.lineHeight));
    }
    this.painted = true;
    $(document).trigger('paint-next', [index + 1, raiseEvent]);
};

CanvasText.prototype.getTextLines = function (text, maxWidth, context) {
    var words = text.split(" ");
    var countWords = words.length;
    var lines = [];
    var line = '';
    for (var n = 0; n < countWords; n++) {
        var testLine = line + words[n] + " ";
        var testWidth = context.measureText(testLine).width;
        if (testWidth > maxWidth) {
            lines.push(line);
            line = words[n] + " ";
        }
        else {
            line = testLine;
        }
    }
    lines.push(line);
    return lines;
};

CanvasText.prototype.update = function (object) {
    ColoredBlock.prototype.update.apply(this, arguments);
    this.text = object.text;
    this.font.name = object.font.name;
    this.font.size = object.font.size;
    this.font.lineHeight = object.font.lineHeight;
    this.font.align = object.font.align;
    this.font.baseline = object.font.baseline;
    this.font.direction = object.font.direction;
};

CanvasText.prototype.toArray = function () {
    return $.merge(ColoredBlock.prototype.toArray.apply(this, arguments), [
        this.text,
        this.font.name,
        this.font.size,
        this.font.lineHeight,
        this.font.align,
        this.font.baseline,
        this.font.direction
    ]);
};

CanvasText.prototype.fromArray = function (array) {
    return new CanvasText(
        new Position(array[0], array[1]),
        new Size(array[2], array[3]),
        new Color(array[4], array[5], array[6], array[7]),
        array[8],
        new Font(array[9], array[10], array[11], array[12], array[13], array[14])
    );
};