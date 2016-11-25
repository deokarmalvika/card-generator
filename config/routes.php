<?php
return [
    'home' => ['GET', '/', 'NewInventor\CardGenerator\Controllers\Main#home'],
    'loadFile' => ['POST', '/load-file', 'NewInventor\CardGenerator\Controllers\File#loadFile'],
    'saveCard' => ['POST', '/save/card', 'NewInventor\CardGenerator\Controllers\File#saveCard'],
    'saveCsv' => ['POST', '/save/csv', 'NewInventor\CardGenerator\Controllers\File#saveCsv'],
    'downloadZip' => ['GET', '/download/zip', 'NewInventor\CardGenerator\Controllers\File#downloadZip'],
    'downloadPng' => ['GET', '/download/png/[i:id]', 'NewInventor\CardGenerator\Controllers\File#downloadPng'],
    'downloadCsv' => ['GET', '/download/csv', 'NewInventor\CardGenerator\Controllers\File#downloadCsv'],
    'getScenario' => ['GET', '/scenario', 'NewInventor\CardGenerator\Controllers\File#getScenario'],
];