<script>
    window.dummy = {
        image: "<?= \NewInventor\CardGenerator\Helpers\HtmlHelper::imageBlock();?>",
        text: "<?= \NewInventor\CardGenerator\Helpers\HtmlHelper::textBlock();?>",
        rectangle: "<?= \NewInventor\CardGenerator\Helpers\HtmlHelper::rectangleBlock();?>",
        border: "<?= \NewInventor\CardGenerator\Helpers\HtmlHelper::borderBlock();?>",
        fontPreview: "<?= \NewInventor\CardGenerator\Helpers\HtmlHelper::fontPreviewBlock();?>",
        imagePreview: "<?= \NewInventor\CardGenerator\Helpers\HtmlHelper::imagePreviewBlock();?>",
    }
</script>
<script src="<?= publicUrl('js/form-functions.js') ?>"></script>
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