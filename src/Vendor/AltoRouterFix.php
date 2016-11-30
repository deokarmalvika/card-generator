<?php
/**
 * Date: 29.11.16
 * Time: 18:57
 */

namespace NewInventor\CardGenerator\Vendor;


use Exception;

class AltoRouterFix extends \AltoRouter
{
    /**
     * Map a route to a target
     *
     * @param string $method One of 5 HTTP Methods, or a pipe-separated list of multiple HTTP Methods (GET|POST|PATCH|PUT|DELETE)
     * @param string $route The route regex, custom regex must start with an @. You can use multiple pre-set regex filters, like [i:id]
     * @param mixed $target The target where this route should point to. Can be anything.
     * @param string $name Optional name of this route. Supply if you want to reverse route this url in your application.
     * @throws Exception
     */
    public function map($method, $route, $target, $name = null)
    {
        if (strpos($target, '#', 1) !== false) {
            $target = explode('#', $target);
        }
        $this->routes[] = array($method, $route, $target, $name);

        if ($name) {
            if (isset($this->namedRoutes[$name])) {
                throw new Exception("Can not redeclare route '{$name}'");
            } else {
                $this->namedRoutes[$name] = $route;
            }

        }

        return;
    }
}