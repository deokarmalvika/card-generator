<script>
    window.dummy = {
        image: "<?= \NewInventor\CardGenerator\HtmlHelper::imageBlock();?>",
        text: "<?= \NewInventor\CardGenerator\HtmlHelper::textBlock();?>",
        rectangle: "<?= \NewInventor\CardGenerator\HtmlHelper::rectangleBlock();?>",
        border: "<?= \NewInventor\CardGenerator\HtmlHelper::borderBlock();?>"
    }
</script>
<script src="<?= resourceUrl('js/index.js') ?>"></script>
<script src="<?= resourceUrl('js/functions.js') ?>"></script>
<script src="<?= resourceUrl('js/size.js') ?>"></script>
<script src="<?= resourceUrl('js/position.js') ?>"></script>
<script src="<?= resourceUrl('js/color.js') ?>"></script>
<script src="<?= resourceUrl('js/font.js') ?>"></script>
<script src="<?= resourceUrl('js/canvas.js') ?>"></script>
<script src="<?= resourceUrl('js/block.js') ?>"></script>
<script src="<?= resourceUrl('js/colored-block.js') ?>"></script>
<script src="<?= resourceUrl('js/rectangle.js') ?>"></script>
<script src="<?= resourceUrl('js/border.js') ?>"></script>
<script src="<?= resourceUrl('js/text.js') ?>"></script>
<script src="<?= resourceUrl('js/image.js') ?>"></script>
<script src="<?= resourceUrl('js/plugins/jquery.noty.packaged.min.js') ?>"></script>