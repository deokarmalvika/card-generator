var CanvasText = function (position, size, color, text, font) {
    this.text = !!text ? text : '';
    this.font = font.constructor.name === 'Font' ? font : new Font();
    ColoredBlock.apply(this, [position, size, color]);
};

CanvasText.prototype = Object.create(ColoredBlock.prototype);
CanvasText.prototype.constructor = CanvasText;

CanvasText.prototype.paint = function (context) {
    context.fillStyle = this.color.asString();
    var lines = this.getTextLines(this.text, this.size.w, context);
    this.font.applyFont(context);
    var count = lines.length;
    for (var i = 0; i < count; i++) {
        context.fillText(lines[i], this.position.x, this.position.y + (i * this.font.lineHeight));
    }
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