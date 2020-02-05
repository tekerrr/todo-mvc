<?php

namespace App\Http;

use App\Renderable;

class JsonResponse implements Renderable
{
    private $data;

    public static function true(string $message = ''): self
    {
        $json = new self(['success' => true]);

        if ($message) {
            $json->setMessage($message);
        }

        return $json;
    }

    public static function false(string $message = ''): self
    {
        $json = new self(['success' => false]);

        if ($message) {
            $json->setMessage($message);
        }

        return $json;
    }

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function render()
    {
        echo json_encode($this->data);
    }

    private function setMessage(string $message)
    {
        $this->data = array_merge($this->data, ['message' => $message]);
    }
}
