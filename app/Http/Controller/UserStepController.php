<?php

namespace App\Http\Controller;

use App\Auth\Auth;
use App\Http\JsonResponse;
use App\Http\Request;

class UserStepController extends AbstractStepController
{
    public function index(string $todoId)
    {
        if (! $todo = $this->getTodo($todoId)) {
            return JsonResponse::false('Список не найден');
        }

        $todo->load('steps');

        return $todo->toJson();
    }

    public function store(string $todoId)
    {
        if (! $todo = $this->getTodo($todoId)) {
            return JsonResponse::false('Список не найден');
        }

        $request = new Request();

        if ($request->isEmptyField(['body'])) {
            return JsonResponse::false('Заполните поле');
        }

        $step = $todo->steps()->create($request->attributes());

        return $step->toJson();
    }

    public function update(string $todoId, string $id)
    {
        if (! $todo = $this->getTodo($todoId)) {
            return JsonResponse::false('Список не найден');
        }

        $step = $todo->steps()->find($id);

        if (is_null($step)) {
            return JsonResponse::false('Шаг не найден');
        }

        $request = new Request();

        if ($request->isEmptyField(['body'])) {
            return JsonResponse::false('Заполните поле');
        }

        $step->update($request->attributes());

        return JsonResponse::true();
    }

    public function destroy(string $todoId, string $id)
    {
        if (! $todo = $this->getTodo($todoId)) {
            return JsonResponse::false('Список не найден');
        }

        $step = $todo->steps()->find($id);

        if (is_null($step)) {
            return JsonResponse::false('Шаг не найден');
        }

        $step->delete();

        return JsonResponse::true();
    }

    public function destroyCompleted(string $todoId)
    {
        if (! $todo = $this->getTodo($todoId)) {
            return JsonResponse::false('Список не найден');
        }

        $todo->steps()->where('is_completed', true)->delete();

        return JsonResponse::true();
    }

    public function complete(string $todoId, string $id)
    {
        if (! $todo = $this->getTodo($todoId)) {
            return JsonResponse::false('Список не найден');
        }

        $step = $todo->steps()->find($id);

        if (is_null($step)) {
            return JsonResponse::false('Шаг не найден');
        }

        $step->complete();

        return JsonResponse::true();
    }

    public function activate(string $todoId, string $id)
    {
        if (! $todo = $this->getTodo($todoId)) {
            return JsonResponse::false('Список не найден');
        }

        $step = $todo->steps()->find($id);

        if (is_null($step)) {
            return JsonResponse::false('Шаг не найден');
        }

        $step->uncomplete();

        return JsonResponse::true();
    }

    public function completeAll(string $todoId)
    {
        if (! $todo = $this->getTodo($todoId)) {
            return JsonResponse::false('Список не найден');
        }

        if (is_null($todo)) {
            return JsonResponse::false('Список не найден');
        }

        $todo->steps->map->complete();

        return JsonResponse::true();
    }

    public function activateAll(string $todoId)
    {
        if (! $todo = $this->getTodo($todoId)) {
            return JsonResponse::false('Список не найден');
        }

        if (is_null($todo)) {
            return JsonResponse::false('Список не найден');
        }

        $todo->steps->map->uncomplete();

        return JsonResponse::true();
    }

    private function getTodo(string $id)
    {
        if (! $user = Auth::getInstance()->getUser()) {
            return null;
        }

        return $user->todos()->find($id);
    }
}
