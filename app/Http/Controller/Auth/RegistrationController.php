<?php

namespace App\Http\Controller\Auth;

use App\Auth\Auth;
use App\Http\Controller\AbstractController;
use App\Http\Redirect;
use App\Http\Request;
use App\Model\User;

class RegistrationController extends AbstractController
{
    public function get()
    {
        return new \App\View\View('registration');
    }

    public function post()
    {
        $request = new Request();

        if ($request->isEmptyField(['login', 'password'])) {
            return new \App\View\View('registration', ['error' => 'Заполните все поля']);
        }

        $user = User::createUser(
            $request->get('login'),
            $request->get('password')
        );

        if (! $user) {
            return new \App\View\View('registration', ['error' => 'Данный логин занят']);
        }

        Auth::getInstance()->login($user);

        return Redirect::redirect('/');
    }
}
