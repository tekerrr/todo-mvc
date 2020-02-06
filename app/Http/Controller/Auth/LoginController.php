<?php

namespace App\Http\Controller\Auth;

use App\Auth\Auth;
use App\Http\Controller\AbstractController;
use App\Http\Redirect;
use App\Http\Request;
use App\Model\User;

class LoginController extends AbstractController
{
    public function get()
    {
        return new \App\View\View('login');
    }

    public function post()
    {
        $request = new Request();

        if ($request->isEmptyField(['login', 'password'])) {
            return new \App\View\View('login', ['error' => 'Заполните все поля']);
        }

        $user = User::login(
            $request->get('login'),
            $request->get('password')
        );

        if (! $user) {
            return new \App\View\View('login', ['error' => 'Неверный email или пароль']);
        }

        Auth::getInstance()->login($user);

        return Redirect::redirect('/index');
    }
}
