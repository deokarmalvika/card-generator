<?php
ini_set('error_reporting', E_ALL);
session_start();
require __DIR__ . '/../vendor/autoload.php';
use NewInventor\ConfigTool\Config;
use NewInventor\CardGenerator\Router;
use NewInventor\CardGenerator\Helpers\FontHelper;

Config::init(__DIR__ . '/../config');
require_once __DIR__ . '/../functions.php';
FontHelper::writeUserFontsCss();
Router::handleRequest();
session_write_close();