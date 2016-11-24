<script>
    window.dummy = {
        image: "<?= \NewInventor\CardGenerator\HtmlHelper::imageBlock();?>",
        text: "<?= \NewInventor\CardGenerator\HtmlHelper::textBlock();?>",
        rectangle: "<?= \NewInventor\CardGenerator\HtmlHelper::rectangleBlock();?>",
        border: "<?= \NewInventor\CardGenerator\HtmlHelper::borderBlock();?>"
    }
</script>
<script src="<?= publicUrl('js/index.js') ?>"></script>
<script src="<?= publicUrl('js/functions.js') ?>"></script>
<script src="<?= publicUrl('js/size.js') ?>"></script>
<script src="<?= publicUrl('js/position.js') ?>"></script>
<script src="<?= publicUrl('js/color.js') ?>"></script>
<script src="<?= publicUrl('js/font.js') ?>"></script>
<script src="<?= publicUrl('js/canvas.js') ?>"></script>
<script src="<?= publicUrl('js/block.js') ?>"></script>
<script src="<?= publicUrl('js/colored-block.js') ?>"></script>
<script src="<?= publicUrl('js/rectangle.js') ?>"></script>
<script src="<?= publicUrl('js/border.js') ?>"></script>
<script src="<?= publicUrl('js/text.js') ?>"></script>
<script src="<?= publicUrl('js/image.js') ?>"></script>
<script src="<?= publicUrl('js/plugins/jquery.noty.packaged.min.js') ?>"></script>