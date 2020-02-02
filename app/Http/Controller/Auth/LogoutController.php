<?php

namespace App\Http\Controller\Auth;

use App\Auth\Auth;
use App\Http\Controller\AbstractController;
use App\Http\Redirect;

class LogoutController extends AbstractController
{
    public function get()
    {
        Auth::getInstance()->logout();

        return Redirect::redirect('/index');
    }
}
