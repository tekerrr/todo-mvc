<?php

namespace App\Http\Controller;

use App\Http\JsonResponse;
use App\Http\Request;
use App\Model\Todo;

class StepController extends AbstractStepController
{
    public function index()
    {
        $todo = Todo::fromSession()->load('steps');

        return $todo->toJson();
    }

    public function store()
    {
        $request = new Request();

        if ($request->isEmptyField(['body'])) {
            return JsonResponse::false('Заполните поле');
        }

        $step = Todo::fromSession()->steps()->create($request->attributes());

        return $step->toJson();
    }

    public function update(string $id)
    {
        $step = Todo::fromSession()->steps()->find($id);

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

    public function destroy(string $id)
    {
        $step = Todo::fromSession()->steps()->find($id);

        if (is_null($step)) {
            return JsonResponse::false('Шаг не найден');
        }

        $step->delete();

        return JsonResponse::true();
    }

    public function destroyCompleted()
    {
       Todo::fromSession()->steps()->where('is_completed', true)->delete();

        return JsonResponse::true();
    }

    public function complete(string $id)
    {
        $step = Todo::fromSession()->steps()->find($id);

        if (is_null($step)) {
            return JsonResponse::false('Шаг не найден');
        }

        $step->complete();

        return JsonResponse::true();
    }

    public function activate(string $id)
    {
        $step = Todo::fromSession()->steps()->find($id);

        if (is_null($step)) {
            return JsonResponse::false('Шаг не найден');
        }

        $step->uncomplete();

        return JsonResponse::true();
    }

    public function completeAll()
    {
        $todo = Todo::fromSession();

        if (is_null($todo)) {
            return JsonResponse::false('Список не найден');
        }

        $todo->steps->map->complete();

        return JsonResponse::true();
    }

    public function activateAll()
    {
        $todo = Todo::fromSession();

        if (is_null($todo)) {
            return JsonResponse::false('Список не найден');
        }

        $todo->steps->map->uncomplete();

        return JsonResponse::true();
    }
}
