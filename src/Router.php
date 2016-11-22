<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 22.11.2016
 * Time: 22:50
 */

namespace NewInventor\CardGenerator;


use NewInventor\ConfigTool\Config;

class Router
{
    /** @var \AltoRouter */
    protected static $router;

    public static function handleRequest()
    {
        self::$router = new \AltoRouter();
        self::$router->addRoutes(self::getRoutes());
        $match = self::$router->match();
        if ($match && is_callable($match['target'])) {
            call_user_func_array($match['target'], $match['params']);
        } else {
            header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
        }
    }

    /**
     * @return array|mixed
     * @throws \NewInventor\TypeChecker\Exception\ArgumentTypeException
     */
    public static function getRoutes()
    {
        $routes = Config::get('routes');
        $routes = array_map(function ($name, $signature) {
            $signature[] = $name;
            return $signature;
        }, array_keys($routes), array_values($routes));

        return $routes;
    }

    /**
     * @param $name
     * @param array $params
     * @return string
     * @throws \Exception
     */
    public static function generateRoute($name, array $params = [])
    {
        return self::$router->generate($name, $params);
    }
}