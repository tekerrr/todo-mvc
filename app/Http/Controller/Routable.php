<?php

namespace App\Http\Controller;

interface Routable
{
    public function getRoutes(): array;
}
