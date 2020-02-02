<?php

namespace App;

class Application
{
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function run()
    {
        // TODO Auth
//        Auth::getInstance()->run();

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
