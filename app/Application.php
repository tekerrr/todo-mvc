<?php

namespace App;

use App\Auth\Auth;

class Application
{
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function run()
    {
        Auth::getInstance()->run();

        try {
            $result = $this->router->dispatch();

            if (is_object($result) && $result instanceof Renderable) {
                $result->render();
            } else {
                echo (string) $result;
            }
        } catch (\Exception $e) {
            $this->renderException($e);
        }
    }

    private function renderException(\Exception $e)
    {
        if ($e instanceof Renderable) {
            $e->render();
        } else {
            echo 'Возникла ошибка номер ' . ($e->getCode() ?: 500) . ' с текстом: ' . $e->getMessage();
        }
    }
}
