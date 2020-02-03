<?php

namespace App\Http\Controller;

use App\Http\Redirect;
use App\Http\Request;
use App\Model\Step;
use App\Model\Todo;
use App\View\View;

class StepController extends AbstractController
{
    public function index()
    {
        $todo = Todo::fromSession()->load('steps');

        return new View('todo.index', compact('todo'));
    }

    /**
     * @return \App\Renderable
     * @throws \Exception
     */
    public function store()
    {
        $request = new Request();

        if ($request->isEmptyField(['body'])) {
            return Redirect::redirectToRoute('steps.index'); // return false [frontend]
        }

        Todo::fromSession()->steps()->create($request->attributes());

        return Redirect::redirectToRoute('steps.index'); // return {step}|true [frontend]
    }

    /**
     * @param string $id
     * @return \App\Renderable
     * @throws \Exception
     */
    public function update(string $id)
    {
        $step = Todo::fromSession()->steps()->find($id);

        if (is_null($step)) {
            return Redirect::redirectToRoute('steps.index'); // return false [frontend]
        }

        $request = new Request();

        if ($request->isEmptyField(['body'])) {
            return Redirect::redirectToRoute('steps.index'); // return false [frontend]
        }

        $step->update($request->attributes());

        return Redirect::redirectToRoute('steps.index'); // return true|false [frontend]
    }

    /**
     * @param string $id
     * @return \App\Renderable
     * @throws \Exception
     */
    public function delete(string $id)
    {
        $step = Todo::fromSession()->steps()->find($id);

        if (is_null($step)) {
            return Redirect::redirectToRoute('steps.index'); // return false [frontend]
        }

        $step->delete();

        return Redirect::redirectToRoute('steps.index'); // return true|false [frontend]
    }

    /**
     * @param string $id
     * @return \App\Renderable
     * @throws \Exception
     */
    public function complete(string $id)
    {
        $step = Todo::fromSession()->steps()->find($id);

        if (is_null($step)) {
            return Redirect::redirectToRoute('steps.index'); // return false [frontend]
        }

        $step->complete();

        return Redirect::redirectToRoute('steps.index'); // return true|false [frontend]
    }

    /**
     * @param string $id
     * @return \App\Renderable
     * @throws \Exception
     */
    public function uncomplete(string $id)
    {
        $step = Todo::fromSession()->steps()->find($id);

        if (is_null($step)) {
            return Redirect::redirectToRoute('steps.index'); // return false [frontend]
        }

        $step->uncomplete();

        return Redirect::redirectToRoute('steps.index'); // return true|false [frontend]
    }
}
