<?php
return [
    'home' => ['GET', '/', 'NewInventor\CardGenerator\Controllers\Main#home'],
    'loadFile' => ['POST', '/load-file', 'NewInventor\CardGenerator\Controllers\File#loadFile'],
    'saveCard' => ['POST', '/save/card', 'NewInventor\CardGenerator\Controllers\File#saveCard'],
    'saveCsv' => ['POST', '/save/csv', 'NewInventor\CardGenerator\Controllers\File#saveCsv'],
    'downloadZip' => ['GET', '/download/zip', 'NewInventor\CardGenerator\Controllers\File#downloadZip'],
    'downloadPng' => ['GET', '/download/card/png/[i:id]', 'NewInventor\CardGenerator\Controllers\File#downloadCardPng'],
    'downloadCsv' => ['GET', '/download/card/csv', 'NewInventor\CardGenerator\Controllers\File#downloadCardCsv'],
    'downloadCardZip' => ['GET', '/download/card/zip', 'NewInventor\CardGenerator\Controllers\File#downloadCardZip'],
    'getScenario' => ['GET', '/scenario', 'NewInventor\CardGenerator\Controllers\File#getScenario'],
];