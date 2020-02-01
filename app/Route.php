<?php

namespace App;

use App\Http\Controllers\AbstractController;
use App\Formatter\Path;

class Route
{
    private $method;
    private $path;
    private $callback;

    /**
     * Route constructor.
     * @param string $method get|post
     * @param string $path uri
     * @param $callback
     */
    public function __construct(string $method, string $path, $callback)
    {
        $this->method = $method;
        $this->path = $this->preparePath($path);
        $this->callback = $callback;
    }

    public static function getMatchExpression(string $path): string
    {
        return '/^' . str_replace(['*', '/'], ['\w+', '\/'], $path) . '$/';
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $method get|post
     * @param string $uri
     * @return bool
     */
    public function match(string $method, string $uri): bool
    {
        return ($method == $this->method) && preg_match($this->getMatchExpression($this->getPath()), $this->preparePath($uri));
    }

    /**
     * @param $uri
     * @return Renderable|string|mixed
     * @throws \Exception
     */
    public function run($uri)
    {
        return call_user_func_array(
            $this->prepareCallback($this->callback),
            $this->getParams($this->preparePath($uri))
        );
    }

    /**
     * Format '/about/', '/about', 'about/', 'about' to '/about'
     * @param string $path
     * @return string
     */
    private function preparePath(string $path): string
    {
        return (new Path())->format($path);
    }

    /**
     * @param $callback
     * @return callable
     * @throws \Exception
     */
    private function prepareCallback($callback)
    {
        if (is_string($callback)) {
            $callback = $this->getCallbackFromString($callback);
        }

        if (is_callable($callback)) {
            return $callback;
        }

        throw new \Exception('Callback ' . (string)$callback . ' не может быть вызван');
    }

    /**
     * @param $string
     * @return array
     * @throws \Exception
     */
    private function getCallbackFromString($string): array
    {
        $array = explode('@', $string);
        if ($this->checkControllerClass($array[0]) && method_exists($controller = new $array[0], $array[1])) {
            return [$controller, $array[1]];
        }

        throw new \Exception('Не сущестсует метод "' . $array[1] . '" класса "' . $array[0] . '"');
    }

    private function checkControllerClass(string $class): bool
    {
        return is_a($class, AbstractController::class, true);
    }

    private function getParams(string $uri): array
    {
        $paths = explode('/', $this->getPath());
        $uris = explode('/', $uri);
        $params = [];

        for ($i = 0; $i < count($paths); $i++) {
            if ($paths[$i] == '*') {
                $params[] = $uris[$i];
            }
        }

        return $params;
    }

}
