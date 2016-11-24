<?php
define('TRIM_CHARS', " \t\n\r\0\x0B/");

if(!function_exists('basePath')){
    /**
     * @param string $path
     * @return string
     */
    function basePath($path){
        return \NewInventor\ConfigTool\Config::get('main.basePath') . '/' . trim($path, TRIM_CHARS);
    }
}
if(!function_exists('viewPath')){
    /**
     * @param string $path
     * @return string
     */
    function viewPath($path){
        return \NewInventor\ConfigTool\Config::get('main.basePath') . '/views/' . trim($path, TRIM_CHARS);
    }
}
if(!function_exists('publicPath')){
    /**
     * @param string $path
     * @return string
     */
    function publicPath($path){
        return \NewInventor\ConfigTool\Config::get('main.basePath') . '/public/' . trim($path, TRIM_CHARS);
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
if(!function_exists('publicUrl')){
    /**
     * @param string $path
     * @return string
     */
    function publicUrl($path){
        return \NewInventor\ConfigTool\Config::get('main.baseUrl') . '/' . trim($path, TRIM_CHARS);
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