<?php
$template = "@font-face {\n\tfont-family: '%name%';\n\tsrc: url('fonts/%name%.ttf') format('truetype')\n}\n\n";

$dir = new DirectoryIterator(__DIR__ . '/fonts');

$f = fopen('available-fonts.css', 'wb');
foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot()) {
        fwrite($f, str_replace('%name%', substr($fileinfo->getFilename(), 0, -4), $template));
    }
}

fclose($f);