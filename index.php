<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
use NewInventor\ConfigTool\Config;
use \NewInventor\CardGenerator\Router;

Config::init(__DIR__ . '/config');
require_once __DIR__ . '/functions.php';
Router::handleRequest();

session_write_close();