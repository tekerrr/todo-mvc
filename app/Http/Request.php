<?php

namespace App\Http;

use App\Formatter\Path;

class Request
{
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_PUT = 'PUT';
    public const METHOD_DELETE = 'DELETE';

    private $methodFieldName = '_method';
    private $method;

    public function __construct()
    {
        $this->setMethod();
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return (new Path())->format($_SERVER['REQUEST_URI']);
    }

    private function setMethod()
    {
        $this->method = $this->isPostRequest() ? $this->getPostRequestMethod() : self::METHOD_GET;
    }

    private function isPostRequest(): bool
    {
        return $_SERVER['REQUEST_METHOD'] == self::METHOD_POST;
    }

    private function getPostRequestMethod(): string
    {
        $method = $this->getMethodFromForm();

        if ($method == self::METHOD_PUT) {
            return self::METHOD_PUT;
        }

        if ($method == self::METHOD_DELETE) {
            return self::METHOD_DELETE;
        }

        return self::METHOD_POST;
    }

    private function getMethodFromForm(): string
    {
        return $_POST[$this->methodFieldName] ?? '';
    }
}
