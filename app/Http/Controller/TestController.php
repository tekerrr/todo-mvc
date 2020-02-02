<?php

namespace App\Http\Controller;

class TestController extends AbstractController
{
    public function test()
    {
        var_dump(\App\Model\User::first()->login);

        return 'test index';
    }

    public function test1()
    {
        return \App\Http\Redirect::redirectToRoute('test2');
    }
}
