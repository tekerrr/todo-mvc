<?php

namespace App;

use App\Http\Controller\Routable;
use App\Http\Request;

class Router
{
    private static $routes = [];

    public function setController(Routable $controller)
    {
        foreach ($controller->getRoutes() as $route) {
            $this->addRoute($route['name'], $route['method'], $route['path'], $route['controllerMethod']);
        }
    }

    public function get(string $name, string $path, $callback)
    {
        $this->addRoute($name,Request::METHOD_GET, $path, $callback);
    }

    public function post(string $name, string $path, $callback)
    {
        $this->addRoute($name,Request::METHOD_POST, $path, $callback);
    }

    public function put(string $name, string $path, $callback)
    {
        $this->addRoute($name,Request::METHOD_PUT, $path, $callback);
    }

    public function delete(string $name, string $path, $callback)
    {
        $this->addRoute($name,Request::METHOD_DELETE, $path, $callback);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function dispatch()
    {
        $request = new Request();

        if ($route = $this->findCurrentRoute($request->getMethod(), $uri = $request->getUri())) {
            return $route->run($uri);
        }

        throw new \Exception('Страница не найдена', '404');
    }

    /**
     * @param string $routeName
     * @return string
     * @throws \Exception
     */
    public function getRoutePath(string $routeName): string
    {
        if ($route = $this->getRoute($routeName)) {
            return $route->getPath();
        }

        throw new \Exception('Путь не найден');
    }

    private function getRoute(string $routeName): ?Route
    {
        return self::$routes[$routeName] ?? null;
    }

    private function getRoutes(): array
    {
        return self::$routes;
    }

    private function addRoute($name, $method, $path, $callback)
    {
        self::$routes[$name] = new Route($method, $path, $callback);
    }

    private function findCurrentRoute($method, $path): ?Route
    {
        foreach ($this->getRoutes() as $route) {
            if ($route->match($method, $path)) {
                return $route;
            }
        }

        return null;
    }
}
