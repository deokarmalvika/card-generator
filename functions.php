<?php
define('TRIM_CHARS', " \t\n\r\0\x0B/");

if(!function_exists('basePath')){
    /**
     * @param string $path
     * @return string
     */
    function basePath($path){
        return __DIR__ . '/' . trim($path, TRIM_CHARS);
    }
}
if(!function_exists('viewPath')){
    /**
     * @param string $path
     * @return string
     */
    function viewPath($path){
        return __DIR__ . '/views/' . trim($path, TRIM_CHARS);
    }
}
if(!function_exists('resourcePath')){
    /**
     * @param string $path
     * @return string
     */
    function resourcePath($path){
        return __DIR__ . '/resources/' . trim($path, TRIM_CHARS);
    }
}
if(!function_exists('baseUrl')){
    /**
     * @param string $path
     * @return string
     */
    function baseUrl($path){
        return \NewInventor\ConfigTool\Config::get('main.baseUrl') . '/' . trim($path, TRIM_CHARS);
    }
}
if(!function_exists('resourceUrl')){
    /**
     * @param string $path
     * @return string
     */
    function resourceUrl($path){
        return \NewInventor\ConfigTool\Config::get('main.baseUrl') . '/resources/' . trim($path, TRIM_CHARS);
    }
}
if(!function_exists('route')){
    /**
     * @param string $name
     * @param array $params
     * @return string
     */
    function route($name, array $params = []){
        return \NewInventor\CardGenerator\Router::generateRoute($name, $params);
    }
}