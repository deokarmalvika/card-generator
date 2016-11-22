<?php
return [
    'home' => ['GET', '/', 'NewInventor\CardGenerator\Controllers\Main#home'],
    'loadFile' => ['POST', '/load-file', 'NewInventor\CardGenerator\Controllers\File#loadFile'],
    'getImagePath' => ['GET', '/get-image-path/[:image]', 'NewInventor\CardGenerator\Controllers\File#getImagePath'],
    'getFontPath' => ['GET', '/get-font-path/[:font]', 'NewInventor\CardGenerator\Controllers\File#getFontPath'],
    'saveCard' => ['POST', '/save-card', 'NewInventor\CardGenerator\Controllers\File#saveCard'],
    'zipProcess' => ['POST', '/zipProcess', 'NewInventor\CardGenerator\Controllers\File#zipProcess'],
];