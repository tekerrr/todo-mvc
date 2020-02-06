<?php

namespace App\Http\Controller;

use App\Auth\Auth;
use App\Http\Redirect;
use App\Http\Request;
use App\View\View;

class TodoController extends AbstractController
{
    public function index()
    {
        if (! $user = Auth::getInstance()->getUser()) {
            return Redirect::redirect('/');
        }

        $todos = $user->load('todos')->todos;

        return new View('todos.index', compact('todos'));
    }

    public function show(string $id)
    {
        if (! $user = Auth::getInstance()->getUser()) {
            return Redirect::redirect('/');
        }

        if (! $todo = $user->todos()->find($id)) {
            return Redirect::redirect('/');
        }

        return new View('index', compact('todo'));
    }

    public function store()
    {
        if (! $user = Auth::getInstance()->getUser()) {
            return Redirect::redirect('/');
        }

        $request = new Request();

        if ($request->isEmptyField(['name'])) {
            return new \App\View\View('todos.index', ['todos' => $user->todos, 'error' => 'Заполните все поля']);
        }

        $user->todos()->create(['name' => $request->get('name')]);

        return Redirect::redirect('/todos');
    }

    public function destroy(string $id)
    {
        if (! $user = Auth::getInstance()->getUser()) {
            return Redirect::redirect('/');
        }

        if (! $todo = $user->todos()->find($id)) {
            return Redirect::redirect('/');
        }

        $todo->delete();

        return Redirect::redirect('/todos');
    }
}
