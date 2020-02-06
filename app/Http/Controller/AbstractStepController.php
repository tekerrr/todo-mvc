<?php

namespace App\Http\Controller;

use App\Http\Request;

abstract class AbstractStepController extends AbstractController implements Routable
{
    private $name;
    private $path;
    private $class;

    public function __construct()
    {
        $this->class = get_class($this);
    }

    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    public function setPath(string $path)
    {
        $this->path = $path;

        return $this;
    }

    public function getRoutes(): array
    {
        return [
            [
                'name'             => $this->name . '.index',
                'method'           => Request::METHOD_GET,
                'path'             => $this->path . '',
                'controllerMethod' => $this->class . '@index',
            ],
            [
                'name'             => $this->name . '.store',
                'method'           => Request::METHOD_POST,
                'path'             => $this->path . '',
                'controllerMethod' => $this->class . '@store',
            ],
            [
                'name'             => $this->name . '.update',
                'method'           => Request::METHOD_PUT,
                'path'             => $this->path . '/*',
                'controllerMethod' => $this->class . '@update',
            ],
            [
                'name'             => $this->name . '.destroy.completed',
                'method'           => Request::METHOD_DELETE,
                'path'             => $this->path . '/completed',
                'controllerMethod' => $this->class . '@destroyCompleted',
            ],
            [
                'name'             => $this->name . '.destroy',
                'method'           => Request::METHOD_DELETE,
                'path'             => $this->path . '/*',
                'controllerMethod' => $this->class . '@destroy',
            ],
            [
                'name'             => $this->name . '.complete.all',
                'method'           => Request::METHOD_PUT,
                'path'             => $this->path . '/all/complete',
                'controllerMethod' => $this->class . '@completeAll',
            ],
            [
                'name'             => $this->name . '.activate.all',
                'method'           => Request::METHOD_PUT,
                'path'             => $this->path . '/all/activate',
                'controllerMethod' => $this->class . '@activateAll',
            ],
            [
                'name'             => $this->name . '.complete',
                'method'           => Request::METHOD_PUT,
                'path'             => $this->path . '/*/complete',
                'controllerMethod' => $this->class . '@complete',
            ],
            [
                'name'             => $this->name . '.activate',
                'method'           => Request::METHOD_PUT,
                'path'             => $this->path . '/*/activate',
                'controllerMethod' => $this->class . '@activate',
            ],
        ];
    }
}
